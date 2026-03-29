<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class MockTestController extends BaseController
{
    private $apiKey;
    protected $paymentService;

    public function __construct()
    {
        $this->apiKey = env('openai_api_key_paid') ?: env('openai_api_key');
        $this->paymentService = new \App\Libraries\PaymentService();
    }

    private function checkAuth()
    {
        if (!session()->get('isLoggedIn')) {
            return false;
        }
        return true;
    }

    private function validateAccess(int $toolId, $input)
    {
        if (!$this->paymentService->isPaymentEnabled()) {
            return true;
        }

        $toolModel = new \App\Models\AiToolModel();
        $tool = $toolModel->find($toolId);
        if (!$tool || $tool['price'] <= 0) {
            return true;
        }

        $paymentId = $input['razorpay_payment_id'] ?? null;
        $orderId = $input['razorpay_order_id'] ?? null;
        $signature = $input['razorpay_signature'] ?? null;
        $couponCode = $input['coupon_code'] ?? null;

        $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, session()->get('user_id'));
        if (isset($calc['final_price']) && $calc['final_price'] <= 0) {
            return true;
        }

        if (!$paymentId || !$orderId || !$signature) {
            return false;
        }

        return $this->paymentService->verifySignature($orderId, $paymentId, $signature);
    }

    public function checkPrice()
    {
        $input = $this->request->getJSON(true);
        $toolId = $input['tool_id'] ?? 10; // Default to Mock Test ID
        $couponCode = $input['coupon_code'] ?? null;
        $userId = session()->get('user_id');

        $result = $this->paymentService->calculateFinalPrice((int) $toolId, $couponCode, $userId);

        // Add CSRF hash for convenience
        $result['csrf_token'] = csrf_hash();

        return $this->response->setJSON($result);
    }

    public function index($type)
    {
        if (!$this->checkAuth())
            return redirect()->to(base_url('login'));

        $validTests = ['ielts', 'pte', 'duolingo', 'gre', 'gmat', 'sat', 'act', 'toefl'];
        if (!in_array($type, $validTests)) {
            return redirect()->to(base_url('ai-tools'));
        }

        $titles = [
            'ielts' => 'IELTS Academic & General',
            'pte' => 'PTE Academic',
            'duolingo' => 'Duolingo English Test',
            'gre' => 'GRE General Test',
            'gmat' => 'GMAT Focus Edition',
            'sat' => 'Digital SAT',
            'act' => 'ACT Test',
            'toefl' => 'TOEFL iBT'
        ];

        $db = \Config\Database::connect();
        $tool = $db->table('ai_tools')->where('id', 10)->get()->getRowArray();
        $settings = $db->table('site_config')->get()->getResultArray();
        $config = [];
        foreach ($settings as $s) {
            $val = $s['config_value'];
            $decoded = json_decode($val, true);
            $config[$s['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }

        return view('web/ai/mock-test/landing', [
            'title' => $titles[$type] . ' Mock Test | UniHunt',
            'test_type' => $type,
            'test_name' => $titles[$type],
            'tool' => $tool,
            'settings' => $config,
            'paymentEnabled' => $this->paymentService->isPaymentEnabled()
        ]);
    }

    public function start($type)
    {
        if (!$this->checkAuth())
            return redirect()->to(base_url('login'));

        $input = $this->request->getPost();
        if (!$this->validateAccess(10, $input)) {
            // Explicitly redirect to the landing page of the test type to avoid confusion
            return redirect()->to(base_url("ai-tools/$type"))->with('error', 'Payment required to start the mock test.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(10, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }

        $testStructure = $this->getTestStructure($type);
        $questions = $this->fetchAiQuestions($type, $testStructure);

        session()->set('current_mock_test', [
            'type' => $type,
            'questions' => $questions,
            'start_time' => time()
        ]);

        return view('web/ai/mock-test/runner', [
            'title' => strtoupper($type) . ' Test In Progress',
            'test_type' => $type,
            'questions' => $questions
        ]);
    }

    public function submit()
    {
        if (!$this->checkAuth())
            return $this->response->setJSON(['error' => 'Unauthorized']);

        $userId = session()->get('user_id');
        if (!$userId) {
            return $this->response->setJSON(['error' => 'User ID not found in session']);
        }

        try {
            $input = $this->request->getJSON(true);
            $responses = $input['responses'] ?? [];
            $testType = $input['test_type'] ?? 'unknown';

            $sessionData = session()->get('current_mock_test');
            $questions = $sessionData['questions'] ?? [];

            // Grading Logic
            $grading = $this->gradeTest($testType, $questions, $responses);

            // Save to DB
            $db = \Config\Database::connect();
            $dataToInsert = [
                'user_id' => $userId,
                'test_type' => $testType,
                'score_summary' => json_encode($grading['summary']),
                'detailed_report' => json_encode($grading['report']),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $db->table('mock_attempts')->insert($dataToInsert);
            $insertId = $db->insertID();

            return $this->response->setJSON([
                'redirect' => base_url("ai-tools/mock-result/" . $insertId)
            ]);
        } catch (\Exception $e) {
            log_message('error', '[MockSubmit] Error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Server Error: ' . $e->getMessage()]);
        }
    }

    public function result($attemptId)
    {
        if (!$this->checkAuth())
            return redirect()->to(base_url('login'));

        $db = \Config\Database::connect();
        $attempt = $db->table('mock_attempts')->where('id', $attemptId)->get()->getRowArray();

        if (!$attempt || $attempt['user_id'] != session()->get('user_id')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('web/ai/mock-test/result', [
            'title' => 'Test Results | UniHunt',
            'attempt' => $attempt,
            'summary' => json_decode($attempt['score_summary'], true),
            'report' => json_decode($attempt['detailed_report'], true)
        ]);
    }

    private function getTestStructure($type)
    {
        // Define simple structures for generation
        switch ($type) {
            case 'ielts':
                return "Reading (3 passages, 40 questions total), Writing (2 tasks), Speaking (3 parts), Listening (40 questions)";
            case 'pte':
                return "Speaking & Writing section, Reading (15 to 20 questions total), Listening section";
            case 'duolingo':
                return "Reading section (20 to 25 questions), Adaptive Literacy, Writing and Speaking tasks";
            case 'gre':
                return "Verbal Reasoning (40 Scored MCQs across 2 sections + 23 questions optional section), Quantitative Reasoning (40 Scored MCQs across 2 sections + 21 questions optional section), Total 80 Scored MCQs";
            case 'gmat':
                return "Quantitative Reasoning (21 questions), Verbal Reasoning (23 questions), Data Insights (20 questions), Total 64 questions";
            case 'sat':
                return "Reading & Writing (54 questions), Math (44 questions), Total 98 questions";
            case 'act':
                return "English (75 questions), Math (60 questions), Reading (40 questions), Science (40 questions), Total 215 questions";
            case 'toefl':
                return "Reading (2 passages, 20 questions total), Listening (28 questions total), Speaking (4 tasks), Writing (2 tasks: Integrated & Academic Discussion)";
            default:
                return "General Aptitude (5 questions)";
        }
    }

    private function fetchAiQuestions($type, $structure)
    {
        $prompt = "Generate a valid JSON object for a {$type} mock test. 
        Structure requirement: {$structure}.
        
        The JSON must be exactly this format:
        {
            \"sections\": [
                {
                    \"name\": \"Section Name\",
                    \"passage\": \"Full reading passage text here... (optional, if applicable)\",
                    \"instructions\": \"Instructions...\",
                    \"questions\": [
                        {
                            \"id\": 1,
                            \"type\": \"mcq\" OR \"text\" OR \"speaking_text\",
                            \"prompt\": \"Question text...\",
                            \"options\": [\"A\", \"B\", \"C\", \"D\"] (only for mcq),
                            \"correct_answer\": \"Index 0-3\" (only for mcq, internal use)
                        }
                    ]
                }
            ]
        }
        Do not output markdown. Only JSON.";

        $response = $this->callAi($prompt, true);
        $data = json_decode($response, true) ?? ['sections' => []];

        // Save generated questions to DB for future use
        if (!empty($data['sections'])) {
            $db = \Config\Database::connect();
            foreach ($data['sections'] as $section) {
                foreach ($section['questions'] as $q) {
                    $db->table('mock_questions')->insert([
                        'test_type' => $type,
                        'section' => $section['name'],
                        'content' => $q['prompt'],
                        'options' => isset($q['options']) ? json_encode($q['options']) : null,
                        'correct_answer' => $q['correct_answer'] ?? null,
                        'difficulty' => 'Medium',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        // Log AI Usage (Tool ID 10: Proficiency Mock Test Generator)
        $this->recordAiUsage(10, ['test_type' => $type, 'structure' => $structure], ['sections_count' => count($data['sections'] ?? [])]);

        return $data;
    }

    private function gradeTest($type, $questions, $responses)
    {
        // 1. Calculate FAQ/Objective scores locally if possible
        // 2. Send subjective answers to AI

        $scoringGuide = "";
        switch ($type) {
            case 'ielts':
                $scoringGuide = "IELTS: 0-9 band score (e.g., 7.5/9.0).";
                break;
            case 'pte':
                $scoringGuide = "PTE: 10-90 scale (e.g., 65/90).";
                break;
            case 'duolingo':
                $scoringGuide = "Duolingo: 10-160 scale (e.g., 120/160).";
                break;
            case 'gre':
                $scoringGuide = "GRE: 260-340 scale (e.g., 310/340).";
                break;
            case 'gmat':
                $scoringGuide = "GMAT: 205-805 scale (e.g., 650/805).";
                break;
            case 'sat':
                $scoringGuide = "SAT: 400-1600 scale (e.g., 1350/1600).";
                break;
            default:
                $scoringGuide = "Percentage score (e.g., 85/100).";
                break;
        }

        $prompt = "Grade this {$type} test submission.
        
        Strict Scoring Scale: {$scoringGuide}
        
        Questions & Context:
        " . json_encode($questions) . "
        
        Student Responses:
        " . json_encode($responses) . "
        
        Provide a JSON output with:
        {
            \"summary\": {
                \"total_score\": \"(Follow the scoring guide exactly)\",
                \"breakdown\": {\"Section Name\": \"Score\"}
            },
            \"report\": \"Detailed feedback paragraph...\"
        }";

        $response = $this->callAi($prompt, true);
        $json = json_decode($response, true);

        if (!$json) {
            return [
                'summary' => ['total_score' => 'Pending', 'breakdown' => []],
                'report' => $response // Raw text fallback
            ];
        }

        // Log AI Usage (Tool ID 10: Proficiency Mock Test Grading)
        $this->recordAiUsage(10, ['test_type' => $type, 'responses_count' => count($responses)], $json);

        return $json;
    }

    private function callAi($prompt, $jsonMode = false)
    {
        if (empty($this->apiKey))
            return "{}";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$this->apiKey}",
            "Content-Type: application/json"
        ]);

        $payload = [
            'model' => 'google/gemini-2.0-flash-001',
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.7
        ];

        if ($jsonMode) {
            $payload['response_format'] = ['type' => 'json_object'];
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $content = $result['choices'][0]['message']['content'] ?? '{}';

        if ($jsonMode) {
            // Clean markdown wrappers if present
            $content = preg_replace('/^.*?({.*}).*$/s', '$1', $content);
        }

        return $content;
    }
}
