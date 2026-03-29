<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\AiToolModel;
use App\Models\AiRequestModel;
use App\Libraries\PaymentService;

class AiController extends BaseController
{
    protected $aiToolModel;
    protected $aiRequestModel;
    protected $paymentService;

    public function __construct()
    {
        $this->aiToolModel = new AiToolModel();
        $this->aiRequestModel = new AiRequestModel();
        $this->paymentService = new PaymentService();
    }

    // PRIORITY: Use consistent AI settings across app (openai_api_key or fallback)
    protected function getAiSettings()
    {
        $db = \Config\Database::connect();
        $query = $db->table('site_config')->whereIn('config_key', ['openai_api_key', 'ai_model', 'ai_temperature'])->get();
        $results = $query->getResultArray();

        $config = [];
        foreach ($results as $row) {
            $val = $row['config_value'];
            $decoded = json_decode($val, true);
            $config[$row['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : $val;
        }

        // 1. API Key priority: .env > DB
        $apiKey = env('openai_api_key_paid') ?: env('openai_api_key');
        if (empty($apiKey)) {
            $apiKey = $config['openai_api_key'] ?? '';
        }
        $apiKey = trim($apiKey, '"\' ');

        // 2. Model Identifier: DB > .env
        $model = $config['ai_model'] ?? '';
        if (empty($model) || trim($model) === '') {
            $model = env('ai_model') ?: 'google/gemini-2.0-flash-001';
        }

        return [
            'apiKey' => $apiKey,
            'model' => trim($model, '"\' '),
            'temperature' => (float) ($config['ai_temperature'] ?? 0.7)
        ];
    }

    /**
     * Get list of all available AI Tools
     */
    public function getTools()
    {
        try {
            $tools = $this->aiToolModel->findAll();
            return $this->response->setJSON([
                'success' => true,
                'data' => $tools
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to fetch AI tools.'
            ]);
        }
    }

    /**
     * Check Price and generate Razorpay Order ID
     */
    public function checkPrice()
    {
        try {
            $input = $this->request->getJSON(true);
            $toolId = (int) ($input['tool_id'] ?? 0);
            $couponCode = $input['coupon_code'] ?? null;
            // From apiauth filter header
            $userId = $this->request->getHeaderLine('X-User-Id');

            if (!$userId) {
                // For API logic, maybe decode JWT or use session fallback, but currently apiauth filter protects this endpoint.
                // Assuming X-User-Id is passed, or extracting from token. Let's use session user_id fallback just in case testing.
                $userId = session()->get('user_id');
            }

            if (!$toolId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'error' => 'Tool ID is required'
                ]);
            }

            $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, $userId);

            if (isset($calc['error'])) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => $calc['error']]);
            }

            $orderId = null;
            if ($calc['final_price'] > 0 && $this->paymentService->isPaymentEnabled()) {
                $receipt = "REQ_" . uniqid();
                $order = $this->paymentService->createRazorpayOrder($calc['final_price'], $receipt);
                if (isset($order['error'])) {
                    return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => $order['error']]);
                }
                $orderId = $order['id'];
            }

            $razorpayKey = $this->paymentService->getRazorpayKey();

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'original_price' => $calc['original_price'],
                    'final_price' => $calc['final_price'],
                    'discount_amount' => $calc['discount_amount'],
                    'status' => $calc['status'],
                    'order_id' => $orderId,
                    'razorpay_key' => $razorpayKey,
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Failed to check price: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Verify the native Razorpay signature
     */
    public function verifyPayment()
    {
        try {
            $input = $this->request->getJSON(true);
            $razorpayOrderId = $input['razorpay_order_id'] ?? '';
            $razorpayPaymentId = $input['razorpay_payment_id'] ?? '';
            $razorpaySignature = $input['razorpay_signature'] ?? '';

            if (empty($razorpayOrderId) || empty($razorpayPaymentId) || empty($razorpaySignature)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'error' => 'Missing payment details.'
                ]);
            }

            $isValid = $this->paymentService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);

            if (!$isValid) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Invalid payment signature.']);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Payment verified successfully.'
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Payment verification failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Generate SOP Content
     */
    public function generateSop()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id'); // From auth context normally

            $name = $input['name'] ?? '';
            $course = $input['course'] ?? '';
            $university = $input['university'] ?? '';
            $background = $input['background'] ?? '';
            $achievements = $input['achievements'] ?? '';

            if (empty($name) || empty($course) || empty($university)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields missing.']);
            }

            // Verify access or handle 100% off coupon
            $couponCode = $input['coupon_code'] ?? null;
            $toolId = 5; // SOP Generator

            // Check if user has paid or has a valid coupon that makes it free
            $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, $userId);

            $isPaid = false;
            if (isset($calc['final_price']) && $calc['final_price'] <= 0) {
                $isPaid = true;
                // Record coupon usage if applicable
                if (!empty($couponCode) && isset($calc['coupon_id'])) {
                    $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) $userId, $calc['discount_amount']);
                }
            } else {
                // Check if razorpay details are provided (for paid tools)
                $razorpayPaymentId = $input['razorpay_payment_id'] ?? null;
                $razorpayOrderId = $input['razorpay_order_id'] ?? null;
                $razorpaySignature = $input['razorpay_signature'] ?? null;

                if ($razorpayPaymentId && $razorpayOrderId && $razorpaySignature) {
                    $isPaid = $this->paymentService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);
                }
            }

            if (!$isPaid && $this->paymentService->isPaymentEnabled()) {
                return $this->response->setStatusCode(403)->setJSON(['success' => false, 'error' => 'Payment required to generate SOP.']);
            }

            // Construct Prompt
            $prompt = "Write a highly professional and tailored Statement of Purpose (SOP) for {$name} applying to the {$course} program at {$university}. "
                . "Their academic/professional background: {$background}. "
                . "Key achievements: {$achievements}. "
                . "Ensure the tone is ambitious, clear, and highlights their genuine passion for the university and program. Output ONLY the SOP content.";

            $settings = $this->getAiSettings();
            $apiKey = $settings['apiKey'];

            if (empty($apiKey)) {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'AI Configuration error: API key missing.']);
            }

            // Reusing the callOpenRouter function from the main logic
            $ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            $payload = [
                "model" => "arcee-ai/trinity-large-preview:free",
                "messages" => [
                    ["role" => "system", "content" => "You are an expert university admissions counselor known for writing compelling statements of purpose."],
                    ["role" => "user", "content" => $prompt]
                ]
            ];
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $apiKey",
                "HTTP-Referer: " . base_url(),
                "X-Title: Unihunt App",
                "Content-Type: application/json"
            ]);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => curl_error($ch)]);
            }
            curl_close($ch);

            $data = json_decode($result, true);
            if (isset($data['choices'][0]['message']['content'])) {
                $generatedContent = $data['choices'][0]['message']['content'];

                if ($userId) {
                    $docModel = new \App\Models\AiDocumentModel();
                    $docModel->insert([
                        'user_id' => $userId,
                        'document_type' => 'sop',
                        'title' => "SOP - {$university}",
                        'content' => $generatedContent,
                        'metadata' => json_encode($input)
                    ]);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'data' => [
                        'content' => $generatedContent
                    ]
                ]);
            } else {
                $errorMsg = $data['error']['message'] ?? 'AI processing failed. Check API key and configuration.';
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $errorMsg]);
            }

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Generation failed: ' . $e->getMessage()
            ]);
        }
    }
    private function _callAi($prompt, $userId, $documentType, $title, $input)
    {
        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];

        if (empty($apiKey)) {
            return ['success' => false, 'error' => 'AI Configuration error: API key missing.'];
        }

        $ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $payload = [
            "model" => $settings['model'],
            "messages" => [
                ["role" => "system", "content" => "You are an expert educational and career counselor."],
                ["role" => "user", "content" => $prompt]
            ],
            "temperature" => $settings['temperature']
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "HTTP-Referer: " . base_url(),
            "X-Title: Unihunt App",
            "Content-Type: application/json"
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['success' => false, 'error' => curl_error($ch)];
        }
        curl_close($ch);

        $data = json_decode($result, true);
        if (isset($data['choices'][0]['message']['content'])) {
            $generatedContent = $data['choices'][0]['message']['content'];

            if ($userId) {
                // Ensure model doesn't crash if table doesn't exist, ignore failures
                try {
                    $docModel = new \App\Models\AiDocumentModel();
                    $docModel->insert([
                        'user_id' => $userId,
                        'document_type' => $documentType,
                        'title' => $title,
                        'content' => $generatedContent,
                        'metadata' => json_encode($input)
                    ]);
                } catch (\Exception $e) {
                }
            }
            return ['success' => true, 'data' => ['content' => $generatedContent]];
        }
        return ['success' => false, 'error' => 'AI processing failed.'];
    }

    public function generateVisa()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id');
            $name = $input['name'] ?? '';
            $country = $input['country'] ?? '';
            $course = $input['course'] ?? '';

            if (empty($name) || empty($country)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields missing.']);
            }

            $couponCode = $input['coupon_code'] ?? null;
            $toolId = 4; // Visa Prep

            // Check for access (payment or waiver)
            $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, $userId);
            $isPaid = false;

            if (isset($calc['final_price']) && $calc['final_price'] <= 0) {
                $isPaid = true;
                if (!empty($couponCode) && isset($calc['coupon_id'])) {
                    $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) $userId, $calc['discount_amount']);
                }
            } else {
                $razorpayPaymentId = $input['razorpay_payment_id'] ?? null;
                $razorpayOrderId = $input['razorpay_order_id'] ?? null;
                $razorpaySignature = $input['razorpay_signature'] ?? null;

                if ($razorpayPaymentId && $razorpayOrderId && $razorpaySignature) {
                    $isPaid = $this->paymentService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);
                }
            }

            if (!$isPaid && $this->paymentService->isPaymentEnabled()) {
                return $this->response->setStatusCode(403)->setJSON(['success' => false, 'error' => 'Payment required to proceed.']);
            }

            // For interactive flow, we return the first question directly if requested
            if (!empty($input['interactive'])) {
                return $this->mockChat();
            }

            $prompt = "Act as an expert Visa Interview prepper for a student. Generate a list of highly probable visa interview questions, tips, and suggested answers for {$name} applying for a student visa to {$country} for a {$course} program.";
            $res = $this->_callAi($prompt, $userId, 'visa', "Visa Prep - {$country}", $input);
            return $this->response->setStatusCode($res['success'] ? 200 : 500)->setJSON($res);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function generateResume()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id');
            $name = $input['name'] ?? '';
            $experience = $input['experience'] ?? '';
            $skills = $input['skills'] ?? '';
            if (empty($name) || empty($skills)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields missing.']);
            }
            $prompt = "Create a professional and ATS-friendly resume for {$name}. Their experience: {$experience}. Key skills: {$skills}. Format it clearly with standard resume sections.";
            $res = $this->_callAi($prompt, $userId, 'resume', "Resume - {$name}", $input);
            return $this->response->setStatusCode($res['success'] ? 200 : 500)->setJSON($res);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function generateCounsellor()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id');
            $name = $input['name'] ?? '';
            $interests = $input['interests'] ?? '';
            $qualifications = $input['qualifications'] ?? '';
            if (empty($name) || empty($interests)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields missing.']);
            }
            $prompt = "Act as an expert career and education counselor. Give personalized advice on university courses and career paths to {$name}, who has qualifications: {$qualifications} and interests in: {$interests}. Suggest potential degrees, countries to study in, and job prospects.";
            $res = $this->_callAi($prompt, $userId, 'counsellor', "Counsellor - {$name}", $input);
            return $this->response->setStatusCode($res['success'] ? 200 : 500)->setJSON($res);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function generateLor()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id');
            $student = $input['student'] ?? '';
            $recommender = $input['recommender'] ?? '';
            $relationship = $input['relationship'] ?? '';
            $strengths = $input['strengths'] ?? '';
            if (empty($student) || empty($recommender)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields missing.']);
            }
            $prompt = "Write a highly professional and glowing Letter of Recommendation for {$student}, written by {$recommender}. The relationship is: {$relationship}. Highlight these key strengths: {$strengths}.";
            $res = $this->_callAi($prompt, $userId, 'lor', "LOR - {$student}", $input);
            return $this->response->setStatusCode($res['success'] ? 200 : 500)->setJSON($res);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function generateMockInterview()
    {
        try {
            $input = $this->request->getJSON(true);
            $userId = $this->request->user_id ?? session()->get('user_id');

            $country = $input['country'] ?? '';
            $visaType = $input['visa_type'] ?? '';
            $university = $input['university'] ?? 'N/A';
            $course = $input['course'] ?? 'N/A';
            $sponsor = $input['sponsor'] ?? 'N/A';
            $finances = $input['finances'] ?? 'N/A';
            $difficulty = $input['difficulty'] ?? 'Medium';

            if (empty($country) || empty($visaType)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'Required fields (Country and Visa Category) are missing.']);
            }

            $couponCode = $input['coupon_code'] ?? null;
            $toolId = 6; // Mock Interview

            // Check for access (payment or waiver)
            $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, $userId);
            $isPaid = false;

            if (isset($calc['final_price']) && $calc['final_price'] <= 0) {
                $isPaid = true;
                if (!empty($couponCode) && isset($calc['coupon_id'])) {
                    $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) $userId, $calc['discount_amount']);
                }
            } else {
                $razorpayPaymentId = $input['razorpay_payment_id'] ?? null;
                $razorpayOrderId = $input['razorpay_order_id'] ?? null;
                $razorpaySignature = $input['razorpay_signature'] ?? null;

                if ($razorpayPaymentId && $razorpayOrderId && $razorpaySignature) {
                    $isPaid = $this->paymentService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);
                }
            }

            if (!$isPaid && $this->paymentService->isPaymentEnabled()) {
                return $this->response->setStatusCode(403)->setJSON(['success' => false, 'error' => 'Payment required to start mock interview.']);
            }

            // For interactive flow, we return the first question directly if requested
            if (!empty($input['interactive'])) {
                return $this->mockChat();
            }

            $prompt = "Act as a Visa Officer at the embassy of {$country}. You are conducting a {$difficulty} difficulty mock interview for a {$visaType} visa.
Applicant Details:
- University: {$university}
- Course: {$course}
- Sponsor: {$sponsor}
- Finances: {$finances}

Generate a comprehensive mock interview script consisting of 5 highly relevant interview questions tailored to the applicant's case, followed by what an ideal and realistic answer would look like for each question. Structure the output clearly.";

            $res = $this->_callAi($prompt, $userId, 'mock_interview', "Mock Interview - {$country} {$visaType}", $input);
            return $this->response->setStatusCode($res['success'] ? 200 : 500)->setJSON($res);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Interactive Mock Chat for Mobile (Stateless)
     */
    public function mockChat()
    {
        try {
            $input = $this->request->getJSON(true);
            $userMessage = $input['message'] ?? '';
            $history = $input['history'] ?? []; // Array of {role: 'user'|'assistant', content: '...'}

            $country = $input['country'] ?? 'USA';
            $visaType = $input['visa_type'] ?? 'Student';
            $difficulty = $input['difficulty'] ?? 'Medium';
            $university = $input['university'] ?? '';
            $course = $input['course'] ?? '';
            $sponsor = $input['sponsor'] ?? '';
            $finances = $input['finances'] ?? '';

            // Build System Prompt
            $systemPrompt = "You are a Visa Officer at the embassy of {$country}. 
            You are conducting a {$difficulty} difficulty mock interview for a {$visaType} visa.
            Applicant Details:
            - University: {$university}
            - Course: {$course}
            - Sponsor: {$sponsor}
            - Annual Finances: {$finances}
            
            Behavior Style:
            - Easy: Supportive, friendly, asks basic questions.
            - Medium: Professional, neutral, asks for some clarifications.
            - Hard: Skeptical, grills the applicant, asks about potential pitfalls (home ties, financial gaps).
            
            RULES:
            1. Keep responses short and conversational (max 2 sentences).
            2. Ask only ONE question at a time.
            3. Stay in character. Do not admit you are an AI.
            4. If history is empty, start by introducing yourself and asking the first question.";

            $messages = [['role' => 'system', 'content' => $systemPrompt]];

            foreach ($history as $h) {
                $messages[] = [
                    'role' => $h['role'] === 'user' ? 'user' : 'assistant',
                    'content' => $h['content']
                ];
            }

            if (!empty($userMessage)) {
                $messages[] = ['role' => 'user', 'content' => $userMessage];
            }

            $settings = $this->getAiSettings();
            $apiKey = $settings['apiKey'];

            if (empty($apiKey)) {
                return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => 'AI Key missing']);
            }

            $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey", "Content-Type: application/json"]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'model' => $settings['model'],
                'messages' => $messages,
                'temperature' => $settings['temperature']
            ]));
            $res = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($res, true);
            $aiResponse = $json['choices'][0]['message']['content'] ?? "Next question?";

            $aiResponse = preg_replace('/<think>.*?<\/think>/s', '', $aiResponse);
            $aiResponse = trim($aiResponse);

            return $this->response->setJSON([
                'success' => true,
                'reply' => $aiResponse
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get Order History for User
     */
    public function getOrders()
    {
        try {
            $userId = $this->request->user_id ?? session()->get('user_id');
            if (!$userId) {
                return $this->response->setStatusCode(401)->setJSON(['success' => false, 'error' => 'Login required']);
            }

            // Fetch successful orders from AiRequestModel
            $requests = $this->aiRequestModel
                ->select('ai_requests.*, ai_tools.name as tool_name')
                ->join('ai_tools', 'ai_tools.id = ai_requests.tool_id')
                ->where('user_id', $userId)
                ->where('payment_status', 'paid')
                ->orderBy('created_at', 'DESC')
                ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'data' => $requests
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Get Specific Order Details (Document Content)
     */
    public function getOrderDetails($orderId)
    {
        try {
            $userId = $this->request->user_id ?? session()->get('user_id');
            $order = $this->aiRequestModel->where('id', $orderId)->where('user_id', $userId)->first();

            if (!$order) {
                return $this->response->setStatusCode(404)->setJSON(['success' => false, 'error' => 'Order not found']);
            }

            // Documents are usually stored in output_data or ai_documents table. 
            // In generateSop etc., we store in ai_documents.
            // Let's check both.

            $content = $order['output_data'] ?? '';

            // Try to find in ai_documents if empty
            if (empty($content)) {
                $docModel = new \App\Models\AiDocumentModel();
                $doc = $docModel->where('user_id', $userId)
                    ->where('created_at >=', date('Y-m-d H:i:s', strtotime($order['created_at']) - 60))
                    ->where('created_at <=', date('Y-m-d H:i:s', strtotime($order['created_at']) + 60))
                    ->first();
                if ($doc) {
                    $content = $doc['content'];
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'id' => $order['id'],
                    'tool_id' => $order['tool_id'],
                    'content' => $content,
                    'created_at' => $order['created_at']
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Finish Interview and get analysis (Stateless)
     */
    public function mockFinish()
    {
        try {
            $input = $this->request->getJSON(true);
            $history = $input['history'] ?? [];
            $country = $input['country'] ?? '';
            $visaType = $input['visa_type'] ?? '';

            if (empty($history)) {
                return $this->response->setStatusCode(400)->setJSON(['success' => false, 'error' => 'No interview history provided.']);
            }

            $transcript = "";
            foreach ($history as $turn) {
                $role = ($turn['role'] === 'assistant') ? "Officer" : "Applicant";
                $transcript .= "{$role}: {$turn['content']}\n";
            }

            $settings = $this->getAiSettings();
            $apiKey = $settings['apiKey'];

            $prompt = "Analyze this mock visa interview transcript for {$country} ({$visaType} visa).
            Return a JSON object with 7 parameters (scores 1-100) and feedback:
            1. 'clarity': Speech clarity and pace.
            2. 'confidence': Lack of fillers and steady delivery.
            3. 'content': Accuracy and persuasiveness of facts.
            4. 'reasoning': Logical connection between answers.
            5. 'language': Vocabulary and grammar.
            6. 'body_language': (Simulate this based on verbal cues).
            7. 'passing_potential': Overall assessment.
            
            Also include:
            - 'feedback': General summary.
            - 'q_analysis': Array of objects with {question, correction, score}.
            - 'total_score': Average of parameters.
            
            Transcript:
            {$transcript}";

            $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey", "Content-Type: application/json"]);

            $payload = [
                'model' => $settings['model'],
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'response_format' => ['type' => 'json_object']
            ];

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            $res = curl_exec($ch);
            curl_close($ch);

            $json = json_decode($res, true);
            $content = $json['choices'][0]['message']['content'] ?? '{}';
            $content = preg_replace('/^.*?({.*}).*$/s', '$1', $content);
            $analysis = json_decode($content, true);

            // Save to DB
            $userId = $this->request->user_id ?? session()->get('user_id');
            if ($userId) {
                $mockModel = new \App\Models\MockInterviewModel();
                $mockModel->insert([
                    'user_id' => $userId,
                    'country' => $country,
                    'visa_type' => $visaType,
                    'transcript' => json_encode($history),
                    'feedback' => json_encode($analysis),
                    'score' => $analysis['total_score'] ?? 0,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $analysis
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

