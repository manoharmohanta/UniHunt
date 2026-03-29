<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AiController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $aiTools = $db->table('ai_tools')->get()->getResultArray();

        // Key by ID for easier access in view
        $tools = [];
        foreach ($aiTools as $t) {
            $tools[$t['id']] = $t;
        }

        return view('web/ai/hub', [
            'aiTools' => $tools,
            'paymentEnabled' => $this->paymentService->isPaymentEnabled()
        ]);
    }

    protected $paymentService;

    public function __construct()
    {
        $this->paymentService = new \App\Libraries\PaymentService();
    }

    private $aiSettings = null;

    private function getAiSettings()
    {
        if ($this->aiSettings !== null)
            return $this->aiSettings;

        $db = \Config\Database::connect();
        $query = $db->table('site_config')->whereIn('config_key', ['openai_api_key', 'ai_model', 'ai_temperature'])->get();
        $results = $query->getResultArray();

        $config = [];
        foreach ($results as $row) {
            $val = $row['config_value'];
            // Tries to decode if it looks like JSON, otherwise keeps original
            $decoded = json_decode($val, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $config[$row['config_key']] = $decoded;
            } else {
                $config[$row['config_key']] = $val;
            }
        }

        // 1. Prioritize .env for API Key as requested by user
        $apiKey = env('openai_api_key_paid') ?: env('openai_api_key');

        // 2. Fallback to DB if .env is empty
        if (empty($apiKey) || trim($apiKey) === '') {
            $apiKey = $config['openai_api_key'] ?? '';
        }

        // Clean up key if it has quotes stored in DB
        $apiKey = trim($apiKey, '"\' ');

        // 3. Model Identifier: Check DB first, then fallback to .env
        $model = $config['ai_model'] ?? '';
        if (empty($model) || trim($model) === '') {
            $model = env('ai_model') ?: 'google/gemini-2.0-flash-001';
        }

        $this->aiSettings = [
            'apiKey' => $apiKey,
            'model' => trim($model, '"\' '),
            'temperature' => (float) ($config['ai_temperature'] ?? 0.7)
        ];
        return $this->aiSettings;
    }

    public function suggestSummary()
    {
        $input = $this->request->getJSON(true);
        $title = $input['title'] ?? '';
        $skills = $input['skills'] ?? '';

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];
        if (empty($apiKey)) {
            log_message('error', 'AI Suggest Summary: API Key missing');
            return $this->response->setJSON(['error' => 'AI Configuration Error: API Key missing', 'csrf_token' => csrf_hash()]);
        }

        $prompt = "Create a professional 2-sentence resume summary for a candidate with the job title: '{$title}'. " .
            (!empty($skills) ? "Core skills: {$skills}. " : "") .
            "Make it impactful and modern. Return only the summary text.";

        try {
            $summary = $this->callOpenRouter($prompt, $apiKey);
        } catch (\Exception $e) {
            log_message('error', 'AI Suggest Summary Exception: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'AI Generation Failed: ' . $e->getMessage(), 'csrf_token' => csrf_hash()]);
        }

        if (empty($summary)) {
            log_message('error', 'AI Suggest Summary: Empty response from AI');
            return $this->response->setJSON(['error' => 'AI returned empty response. Check API logs.', 'csrf_token' => csrf_hash()]);
        }

        // Log AI Usage (Tool ID 9: Resume Summary/Highlights)
        $this->recordAiUsage(9, ['type' => 'summary', 'title' => $title], ['summary' => $summary]);

        return $this->response->setJSON([
            'summary' => trim($summary),
            'csrf_token' => csrf_hash()
        ]);
    }

    public function suggestHighlights()
    {
        $input = $this->request->getJSON(true);
        $title = $input['title'] ?? '';
        $company = $input['company'] ?? '';

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];
        if (empty($apiKey)) {
            log_message('error', 'AI Suggest Highlights: API Key missing');
            return $this->response->setJSON(['error' => 'AI Configuration Error: API Key missing', 'csrf_token' => csrf_hash()]);
        }

        $prompt = "Generate 4 professional bullet points (one per line) for a resume describing responsibilities and achievements in the role of '{$title}'" .
            (!empty($company) ? " at '{$company}'" : "") .
            ". Use action verbs. Return only the bullet points without bullets symbols.";

        try {
            $highlights = $this->callOpenRouter($prompt, $apiKey);
        } catch (\Exception $e) {
            log_message('error', 'AI Suggest Highlights Exception: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'AI Generation Failed: ' . $e->getMessage(), 'csrf_token' => csrf_hash()]);
        }

        if (empty($highlights)) {
            log_message('error', 'AI Suggest Highlights: Empty response from AI');
            return $this->response->setJSON(['error' => 'AI returned empty response. Check API logs.', 'csrf_token' => csrf_hash()]);
        }

        // Log AI Usage (Tool ID 9: Resume Summary/Highlights)
        $this->recordAiUsage(9, ['type' => 'highlights', 'title' => $title], ['highlights' => $highlights]);

        return $this->response->setJSON([
            'highlights' => trim($highlights),
            'csrf_token' => csrf_hash()
        ]);
    }

    private function callOpenRouter($prompt, $apiKey)
    {
        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $settings = $this->getAiSettings();
        $payload = [
            'model' => $settings['model'],
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => $settings['temperature']
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $curlError = curl_error($ch);
            curl_close($ch);
            throw new \Exception("Curl Error: " . $curlError);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            $apiError = $result['error']['message'] ?? $response;
            log_message('error', "OpenRouter API Error ($httpCode): " . $apiError);
            throw new \Exception("API Error ($httpCode): " . $apiError);
        }

        return $result['choices'][0]['message']['content'] ?? "";
    }

    public function generateResume()
    {
        $input = $this->request->getPost();

        // Server-side validation
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'title' => 'required|max_length[100]',
            'email' => 'required|valid_email|max_length[255]',
            'phone' => 'required|numeric|min_length[7]|max_length[15]',
            'experience' => 'permit_empty',
            'education' => 'permit_empty',
            'summary' => 'permit_empty|max_length[1000]',
            'skills' => 'permit_empty|max_length[500]',
            'location' => 'permit_empty|max_length[100]',
            'linkedin' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please fill in all required fields correctly.');
        }

        if (!$this->validateAccess(2, $input)) {
            return redirect()->back()->with('error', 'Payment required to generate resume.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(2, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }

        // Basic personal info
        $name = $input['name'] ?? 'John Doe';
        $email = $input['email'] ?? 'john@example.com';
        $phone = $input['phone'] ?? '123-456-7890';
        $location = $input['location'] ?? 'New York, NY';
        $linkedin = $input['linkedin'] ?? '';
        $title = $input['title'] ?? 'Software Engineer';

        // Complex data structures (JSON strings from form)
        $experience = json_decode($input['experience'] ?? '[]', true);
        $education = json_decode($input['education'] ?? '[]', true);
        $skills = explode(',', $input['skills'] ?? '');
        $skills = array_map('trim', $skills);

        $summary = $input['summary'] ?? '';

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'location' => $location,
            'linkedin' => $linkedin,
            'title' => $title,
            'summary' => $summary,
            'experience' => $experience,
            'education' => $education,
            'skills' => $skills
        ];

        $templateId = $input['template_id'] ?? 1;
        if ($templateId < 1 || $templateId > 10)
            $templateId = 1;

        $html = view("resumes/template{$templateId}", $data);

        if (($input['format'] ?? '') === 'pdf') {
            // Check if user is logged in and save
            $userId = session()->get('user_id');
            if ($userId) {
                $this->saveAiDocument($userId, 'RESUME', "Resume - {$name}", $html, [
                    'template' => $templateId,
                    'title' => $title,
                    'location' => $location
                ]);
            }

            // Log AI Usage (Tool ID 2: Resume Builder)
            $calc = $this->paymentService->calculateFinalPrice(2, $input['coupon_code'] ?? null, $userId);
            $this->recordAiUsage(2, array_merge(['name' => $name, 'title' => $title, 'final_amount' => $calc['final_price'] ?? 0], $input), ['format' => $input['format'] ?? 'html']);

            // Provide a print-ready view
            return $html . '<script>window.onload = function() { window.print(); }</script>';
        }

        return $html;
    }

    public function generateSOP()
    {
        $input = $this->request->getPost();

        // Server-side validation
        $rules = [
            'name' => 'required',
            'home_country' => 'required',
            'target_country' => 'required',
            'university' => 'required',
            'course' => 'required',
            'academic_background' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please fill in all required fields correctly.');
        }

        if (!$this->validateAccess(5, $input)) {
            return redirect()->back()->with('error', 'Payment required to generate SOP.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(5, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }
        $name = $input['name'] ?? 'Applicant';
        $homeCountry = $input['home_country'] ?? 'India';
        $targetCountry = $input['target_country'] ?? 'USA';
        $university = $input['university'] ?? '';
        $course = $input['course'] ?? '';

        // Define word counts based on country
        $shortCountCountries = ['USA', 'UK', 'Ireland', 'Europe'];
        $longCountCountries = ['Canada', 'Australia', 'New Zealand'];

        $wordCount = in_array($targetCountry, $shortCountCountries) ? "750 to 900" : "950 to 1700";

        $prompt = "You are an experienced academic writer specializing in crafting compelling Statements of Purpose (SOP) for international university admissions.\n\n
        
        Write a comprehensive, highly persuasive, and ATS-optimized Statement of Purpose (SOP) for {$name}, who is from {$homeCountry} and applying to {$university} for the {$course} program in {$targetCountry}. 
        
        Your task is to write a detailed, genuine, and personalized Statement of Purpose for a student applying to **{$course}** at **{$university}** in **{$targetCountry}**.\n\n
        
        **Important Requirements:**\n
        - The SOP MUST be approximately {$wordCount} words long\n.
        - Maintain a professional, academic, and enthusiastic tone throughout.\n
        - Structure it with a smooth narrative flow covering personal background, academic and professional experiences, motivations, future goals, and reasons for selecting the course, university, and country.\n
        - Make it unique, coherent, goal-oriented, and convincingly aligned with the applicant’s aspirations and the offerings of the university and course.\n
        - Use action verbs and specific examples to support your points.\n
        - Include a clear and concise conclusion that summarizes your main points and reiterates your commitment to the course and university.\n
        - Proofread the SOP for grammar, spelling, and punctuation errors.\n
        - Avoid generic phrases; use the provided details contextually to build a personalized story.\n\n
        
        Since the user has not provided specific reasons for their choice of university, country, or career plans, YOU must intelligently generate these sections based on the following context:
        - Applicant's Academic Background: {$input['academic_background']}
        - Additional Profile Details: {$input['about_profile']}
        - Target Intake Destination: {$university} in {$targetCountry}
        - Target Program: {$course}
        
        Structure the SOP with these specific sections:
        1. **Professional Silhouette**: A compelling introduction about the applicant's personality and academic/professional identity.
        2. **Academic Foundation**: Detailed reflection on their {$input['academic_background']}.
        3. **Intellectual Passion**: Why they are deeply interested in {$course}. Generate specific, technical reasons why this field is the future.
        4. **Why {$university}?**: Research and generate specific reasons why this university is a top choice (mention reputation, curriculum, faculty, or facilities generically but convincingly).
        5. **Global Perspective: Why {$targetCountry}?**: Generate persuasive reasons for choosing {$targetCountry} over other study destinations (e.g., quality of life, post-study work opportunities, research ecosystem).
        6. **The Road Not Taken**: A strategic explanation of why stay in {$homeCountry} for this specific degree isn't the best path (mentioning lack of specialization or global exposure).
        7. **Future Horizons**: Generate a realistic and ambitious 5-10 year career roadmap. Mention roles, industries, and how this degree from {$university} is the catalyst.
        8. **Closing Statement**: A formal and confident conclusion.

        \n\n### Final Writing Instructions:\n
        - Craft a natural and engaging introduction that captures the applicant’s motivation for pursuing higher studies in {$targetCountry}.\n
        - Narrate the academic journey, including specific achievements, challenges (if provided), and how they shaped the applicant’s career aspirations.\n
        - Discuss academic projects and professional experiences (if any) in detail, emphasizing skills acquired and their relevance to the chosen course.\n
        - If research experience is available, describe it and its significance.\n
        - Highlight extracurricular activities, leadership, volunteer work, or hobbies that reflect a well-rounded personality.\n
        - Express a clear and concise conclusion that summarizes the applicant’s main points and reiterates their commitment to the course and university.\n
        - Conclude with future goals and how this program will help achieve them.\n
        - Ensure the SOP reads like a continuous narrative, avoiding bullet points.\n
        
        TONE: Formal, visionary, academic, and extremely professional. Avoid clichés. Make it sound like it was written by a high-achieving student.";

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];

        $sopContent = $this->fetchAiSOP($prompt, $apiKey);

        // Calculate SOP Health Score
        $healthScore = $this->calculateSOPHealthScore($sopContent, $wordCount);

        // Save to History if logged in
        $userId = session()->get('user_id');
        if ($userId) {
            $this->saveAiDocument($userId, 'SOP', "SOP for {$course} at {$university}", $sopContent, [
                'target_country' => $targetCountry,
                'university' => $university,
                'course' => $course,
                'health_score' => $healthScore
            ]);
        }

        // Log AI Usage (Tool ID 5: SOP Generator)
        $post = $this->request->getPost();
        $calc = $this->paymentService->calculateFinalPrice(5, $post['coupon_code'] ?? null, $userId);
        $this->recordAiUsage(5, array_merge(['name' => $name, 'country' => $targetCountry, 'course' => $course, 'final_amount' => $calc['final_price'] ?? 0], $post), ['score' => $healthScore]);

        return view('web/ai/sop-result', [
            'sop_content' => $sopContent,
            'title' => 'Your Generated SOP | UniHunt',
            'name' => $name,
            'country' => $targetCountry,
            'university' => $university,
            'course' => $course,
            'word_count' => $wordCount,
            'health_score' => $healthScore
        ]);
    }

    private function calculateSOPHealthScore($content, $targetWordCount)
    {
        $score = 0;
        $wordCount = str_word_count(strip_tags($content));

        // Parse target word count range
        $targetRange = explode(' to ', $targetWordCount);
        $minWords = (int) $targetRange[0];
        $maxWords = isset($targetRange[1]) ? (int) $targetRange[1] : $minWords + 250;

        // Word count check (30 points)
        if ($wordCount >= $minWords && $wordCount <= $maxWords) {
            $score += 30;
        } elseif ($wordCount >= $minWords * 0.9 && $wordCount <= $maxWords * 1.1) {
            $score += 20;
        } else {
            $score += 10;
        }

        // Structure check (25 points) - look for section headings
        $sectionCount = preg_match_all('/\*\*[^*]+\*\*/', $content);
        if ($sectionCount >= 6) {
            $score += 25;
        } elseif ($sectionCount >= 4) {
            $score += 20;
        } else {
            $score += 10;
        }

        // Content quality (25 points) - check for key phrases
        $qualityKeywords = ['university', 'research', 'experience', 'passion', 'future', 'career', 'skills'];
        $keywordCount = 0;
        foreach ($qualityKeywords as $keyword) {
            if (stripos($content, $keyword) !== false) {
                $keywordCount++;
            }
        }
        $score += min(25, $keywordCount * 4);

        // Grammar and readability (20 points) - basic checks
        $sentences = preg_split('/[.!?]+/', $content);
        $avgWordsPerSentence = $wordCount / max(count($sentences), 1);
        if ($avgWordsPerSentence >= 15 && $avgWordsPerSentence <= 25) {
            $score += 20;
        } else {
            $score += 15;
        }

        return min(100, $score);
    }

    public function generateLOR()
    {
        $input = $this->request->getPost();

        // Server-side validation
        $rules = [
            'applicant_name' => 'required',
            'recommender_name' => 'required',
            'recommender_title' => 'required',
            'organization' => 'required',
            'projects' => 'required',
            'strengths' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please fill in all required fields correctly.');
        }

        if (!$this->validateAccess(1, $input)) {
            return redirect()->back()->with('error', 'Payment required to generate LOR.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(1, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }
        $applicant = $input['applicant_name'] ?? 'Applicant';
        $recommender = $input['recommender_name'] ?? 'The Recommender';
        $title = $input['recommender_title'] ?? '';
        $org = $input['organization'] ?? '';
        $type = $input['lor_type'] ?? 'Academic';
        $duration = $input['duration'] ?? '';

        $prompt = "Write a highly professional 1-page Letter of Recommendation (LOR) for {$applicant}. 
        The recommender is {$recommender}, working as {$title} at {$org}. 
        They have known each other for {$duration}.
        
        This is a {$type} recommendation. 
        Focus on these projects/achievements: {$input['projects']}
        Highlight these strengths: {$input['strengths']}
        
        The LOR should include:
        - Date and Salutation
        - Introductory paragraph stating the duration and nature of the association.
        - 2 Body paragraphs detailing specific academic/professional contributions and personal attributes.
        - A strong concluding summary recommending the applicant for future endeavors.
        - Formal sign-off.
        
        Keep it within 400-600 words to fit perfectly on one page. Maintain an appreciative and authentic tone.";

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];

        $lorContent = $this->fetchAiLOR($prompt, $apiKey);

        // Save to History
        $userId = session()->get('user_id');
        if ($userId) {
            $this->saveAiDocument($userId, 'LOR', "LOR for {$applicant} by {$recommender}", $lorContent, [
                'type' => $type,
                'recommender' => $recommender,
                'applicant' => $applicant
            ]);
        }

        // Log AI Usage (Tool ID 1: LOR Generator)
        $calc = $this->paymentService->calculateFinalPrice(1, $input['coupon_code'] ?? null, $userId);
        $this->recordAiUsage(1, array_merge(['applicant' => $applicant, 'recommender' => $recommender, 'type' => $type, 'final_amount' => $calc['final_price'] ?? 0], $input), ['length' => strlen($lorContent)]);

        return view('web/ai/lor-result', [
            'lor_content' => $lorContent,
            'title' => 'Your Generated LOR | UniHunt'
        ]);
    }

    public function visaCheckerResult()
    {
        $input = $this->request->getPost();

        // Server-side validation
        if (!$this->validate(['country' => 'required', 'visa_type' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Please select a country and visa type.');
        }

        if (!$this->validateAccess(4, $input)) {
            return redirect()->back()->with('error', 'Payment required to check visa requirements.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(4, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }

        $country = trim($input['country'] ?? 'Generic');
        $visaType = $input['visa_type'] ?? 'Student';

        $visaModel = new \App\Models\VisaKnowledgeBaseModel();

        // 1. Check if we have this exact combination in the DB
        $cached = $visaModel->where('country', $country)
            ->where('visa_type', $visaType)
            ->first();

        if ($cached) {
            $data = $cached;
        } else {
            // 2. Fetch from AI if not in DB
            $settings = $this->getAiSettings();
            $apiKey = $settings['apiKey'];

            $aiData = $this->fetchAiVisaInfo($country, $visaType, $apiKey);

            // 3. Save to DB for next time
            $dataToSave = [
                'country' => $country,
                'visa_type' => $visaType,
                'document_checklist' => $aiData['document_checklist'],
                'travel_plan' => $aiData['travel_plan'],
                'places_to_visit' => $aiData['places_to_visit'],
                'things_to_carry' => $aiData['things_to_carry'],
                'useful_links' => $aiData['useful_links'] ?? '',
                'image_keyword' => $aiData['image_keyword'] ?? ''
            ];

            $visaModel->insert($dataToSave);
            $data = $dataToSave;
            $data['id'] = $visaModel->getInsertID();
        }

        // Log to History
        $userId = session()->get('user_id');
        if ($userId) {
            $this->saveAiSearch($userId, 'VISA_CHECKER', ['country' => $country, 'visa_type' => $visaType], $data['id'] ?? null);
        }

        // Log AI Usage (Tool ID 4: Visa Checker)
        $calc = $this->paymentService->calculateFinalPrice(4, $input['coupon_code'] ?? null, $userId);
        $this->recordAiUsage(4, array_merge(['country' => $country, 'visa_type' => $visaType, 'final_amount' => $calc['final_price'] ?? 0], $input), ['id' => $data['id'] ?? null]);

        return view('web/ai/visa-result', $data);
    }

    public function careerPredictorResult()
    {
        $input = $this->request->getPost();

        // Server-side validation
        if (!$this->validate(['course_name' => 'required', 'home_country' => 'required'])) {
            return redirect()->back()->withInput()->with('error', 'Please enter a course name and home country.');
        }

        if (!$this->validateAccess(3, $input)) {
            return redirect()->back()->with('error', 'Payment required for career prediction.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(3, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }

        $course = trim($input['course_name'] ?? 'Generic Course');
        $homeCountry = trim($input['home_country'] ?? 'Generic');

        $careerModel = new \App\Models\CareerPredictionModel();

        // 1. Check DB Cache
        $cached = $careerModel->where('course_name', $course)
            ->where('home_country', $homeCountry)
            ->first();

        if ($cached) {
            $data = $cached;
        } else {
            // 2. Fetch from AI
            $settings = $this->getAiSettings();
            $apiKey = $settings['apiKey'];

            $aiData = $this->fetchAiCareerInfo($course, $homeCountry, $apiKey);

            // 3. Save to DB
            $dataToSave = [
                'course_name' => $course,
                'home_country' => $homeCountry,
                'job_titles' => $aiData['job_titles'],
                'payscales' => $aiData['payscales'],
                'top_mncs' => $aiData['top_mncs'],
                'career_roadmap' => $aiData['career_roadmap']
            ];

            $careerModel->insert($dataToSave);
            $data = $dataToSave;
            $data['id'] = $careerModel->getInsertID();
        }

        // Log to History
        $userId = session()->get('user_id');
        if ($userId) {
            $this->saveAiSearch($userId, 'CAREER_PREDICTOR', ['course' => $course, 'home_country' => $homeCountry], $data['id'] ?? null);
        }

        // Log AI Usage (Tool ID 3: Career Outcome Predictor)
        $calc = $this->paymentService->calculateFinalPrice(3, $input['coupon_code'] ?? null, $userId);
        $this->recordAiUsage(3, array_merge(['course' => $course, 'home_country' => $homeCountry, 'final_amount' => $calc['final_price'] ?? 0], $input), ['id' => $data['id'] ?? null]);

        return view('web/ai/career-result', $data);
    }

    private function fetchAiCareerInfo($course, $homeCountry, $apiKey)
    {
        if (empty($apiKey)) {
            return [
                'job_titles' => "Data Scientist, Data Analyst, Machine Learning Engineer.",
                'payscales' => "USA: $90k, UK: £50k, {$homeCountry}: ₹15L.",
                'top_mncs' => "Google, Microsoft, Amazon, Meta.",
                'career_roadmap' => "1. Internships, 2. Certifications, 3. Entry-level role."
            ];
        }

        $prompt = "Provide a career forecast for someone graduating in {$course}. The student's home country is {$homeCountry}.
        Return a valid JSON object with:
        'job_titles': (List 5 relevant job titles),
        'payscales': (Average annual pay in the home country ({$homeCountry}) + 4 other top destinations like USA, UK, Canada, Australia),
        'top_mncs': (Names of top 10 MNCs hiring this profile globally),
        'career_roadmap': (A 3-step growth path from Junior to Lead roles).
        
        Format lists cleanly using Markdown (e.g. - Item) inside the JSON strings. No extra text.";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $settings = $this->getAiSettings();
        $payload = [
            'model' => $settings['model'],
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'response_format' => ['type' => 'json_object']
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $content = $result['choices'][0]['message']['content'] ?? '{}';
        $json = json_decode($content, true);

        return [
            'job_titles' => $this->safeImplode(', ', $json['job_titles'] ?? 'Available soon.'),
            'payscales' => $this->safeImplode("\n", $json['payscales'] ?? 'Available soon.'),
            'top_mncs' => $this->safeImplode(', ', $json['top_mncs'] ?? 'Available soon.'),
            'career_roadmap' => $this->safeImplode("\n", $json['career_roadmap'] ?? 'Available soon.')
        ];
    }

    private function fetchAiVisaInfo($country, $visaType, $apiKey)
    {
        if (empty($apiKey)) {
            return [
                'document_checklist' => "Passport, Application Form, Fee Receipt.",
                'travel_plan' => "Day 1: Arrival, Day 2: City Tour.",
                'places_to_visit' => "Central Park, Main Museum.",
                'things_to_carry' => "Universal Adapter, Weather-appropriate clothing.",
                'useful_links' => "https://example.com/visa",
                'image_keyword' => "travel destination"
            ];
        }

        // We use JSON formatting in the prompt to make it easy to parse
        $prompt = "Provide detailed visa and travel info for {$country} for a {$visaType} visa.
        Return the response as a valid JSON object with EXACTLY these keys:
        'document_checklist': (List of mandatory documents),
        'travel_plan': (A 7-day travel itinerary),
        'places_to_visit': (Top 5 locations with descriptions),
        'things_to_carry': (Essential items for this destination),
        'useful_links': (A list of 3-5 real, specific URLs for visa application, tourism board, or embassy of {$country}. Format as 'Title: URL'),
        'image_keyword': (A single English keyword to search for a high-quality background image of this destination, e.g. 'Paris Eiffel Tower' or 'Tokyo Skyline').
        
        Format the content (lists, descriptions) using Markdown where appropriate inside the JSON strings.
        Do not include any other text besides the JSON.";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $settings = $this->getAiSettings();
        $payload = [
            'model' => $settings['model'],
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'response_format' => ['type' => 'json_object']
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        $content = $result['choices'][0]['message']['content'] ?? '{}';

        $json = json_decode($content, true);

        return [
            'document_checklist' => $this->safeImplode("\n\n", $json['document_checklist'] ?? 'Information currently unavailable.'),
            'travel_plan' => $this->safeImplode("\n\n", $json['travel_plan'] ?? 'Information currently unavailable.'),
            'places_to_visit' => $this->safeImplode("\n\n", $json['places_to_visit'] ?? 'Information currently unavailable.'),
            'things_to_carry' => $this->safeImplode("\n\n", $json['things_to_carry'] ?? 'Information currently unavailable.'),
            'useful_links' => $this->safeImplode("\n", $json['useful_links'] ?? 'Not found.'),
            'image_keyword' => $this->safeImplode("", $json['image_keyword'] ?? 'travel')
        ];
    }

    private function safeImplode($glue, $val)
    {
        if (is_string($val))
            return $val;
        if (!is_array($val))
            return (string) $val;

        $pieces = array_map(function ($item) {
            if (is_array($item) || is_object($item)) {
                if (is_array($item)) {
                    // flatten key-value pairs if it's an associative array
                    $parts = [];
                    foreach ($item as $k => $v) {
                        if (is_scalar($v))
                            $parts[] = is_numeric($k) ? $v : "$k: $v";
                    }
                    return implode(', ', $parts);
                }
                return json_encode($item);
            }
            return (string) $item;
        }, $val);

        return implode($glue, $pieces);
    }

    private function fetchAiLOR($prompt, $apiKey)
    {
        if (empty($apiKey))
            return "AI Key not found. Please provide details manually.";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $settings = $this->getAiSettings();
        $payload = [
            'model' => $settings['model'],
            'messages' => [['role' => 'user', 'content' => $prompt . "\n\nIMPORTANT: Return the response in raw Markdown format."]],
            'top_p' => 1,
            'temperature' => $settings['temperature']
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? "Could not generate LOR at this time. Please try again.";
    }

    private function fetchAiSOP($prompt, $apiKey)
    {
        if (empty($apiKey))
            return "AI Key not found. Please provide details manually.";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $settings = $this->getAiSettings();
        $payload = [
            'model' => $settings['model'],
            'messages' => [['role' => 'user', 'content' => $prompt . "\n\nIMPORTANT: Return the response in raw Markdown format."]],
            'top_p' => 1,
            'temperature' => $settings['temperature']
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? "Could not generate SOP at this time. Please try again.";
    }

    private function fetchAiSummary($name, $title, $experience, $skills, $apiKey)
    {
        if (empty($apiKey))
            return "Professional with background in " . implode(', ', array_slice($skills, 0, 3));

        $prompt = "Create a professional 2-sentence resume summary for {$name}, a {$title}. Key skills: " . implode(', ', $skills) . ".";

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);

        $payload = [
            'model' => 'google/gemini-2.0-flash-001', // Or similar available model
            'messages' => [['role' => 'user', 'content' => $prompt]]
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? "Professional " . $title . " with expertise in " . $skills[0];
    }

    public function startMockSession()
    {
        $input = $this->request->getPost();
        if (!$this->validateAccess(6, $input)) {
            return redirect()->back()->with('error', 'Payment required to start mock interview.');
        }

        // Record coupon usage if applicable
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(6, $input['coupon_code'], session()->get('user_id'));
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) session()->get('user_id'), $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }
        session()->set('mock_interview', [
            'country' => $input['country'] ?? 'USA',
            'visa_type' => $input['visa_type'] ?? 'Student',
            'university' => $input['university'] ?? '',
            'course' => $input['course'] ?? '',
            'sponsor' => $input['sponsor'] ?? '',
            'finances' => $input['finances'] ?? '',
            'difficulty' => $input['difficulty'] ?? 'Medium',
            'history' => [],
            'start_time' => time()
        ]);

        return view('web/ai/mock-interview', [
            'title' => 'AI Mock Interview | UniHunt',
            'config' => session()->get('mock_interview')
        ]);
    }

    public function mockChat()
    {
        $input = $this->request->getJSON(true);
        $userMessage = $input['message'] ?? '';
        $sessionData = session()->get('mock_interview');

        if (!$sessionData)
            return $this->response->setJSON(['error' => 'Session expired']);

        // Build System Prompt
        $systemPrompt = "You are a Visa Officer at the embassy of {$sessionData['country']}. 
        You are conducting a {$sessionData['difficulty']} difficulty mock interview for a {$sessionData['visa_type']} visa.
        Applicant Details:
        - University: {$sessionData['university']}
        - Course: {$sessionData['course']}
        - Sponsor: {$sessionData['sponsor']}
        - Annual Finances: {$sessionData['finances']}
        
        Behavior Style:
        - Easy: Supportive, friendly, asks basic questions.
        - Medium: Professional, neutral, asks for some clarifications.
        - Hard: Skeptical, grills the applicant, asks about potential pitfalls (home ties, financial gaps).
        
        RULES:
        1. Keep responses short and conversational (max 2 sentences).
        2. Ask only ONE question at a time.
        3. Stay in character. Do not admit you are an AI.
        4. If the user hasn't spoken yet (initial message), start the interview by introducing yourself.";

        $messages = [['role' => 'system', 'content' => $systemPrompt]];
        foreach ($sessionData['history'] as $turn) {
            if ($turn['user'] !== '[Started Interview]') {
                $messages[] = ['role' => 'user', 'content' => $turn['user']];
            }
            $messages[] = ['role' => 'assistant', 'content' => $turn['ai']];
        }

        if (!empty($userMessage)) {
            $messages[] = ['role' => 'user', 'content' => $userMessage];
        }

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];

        $aiResponse = $this->callOpenRouterForChat($messages, $apiKey);

        // Use regex to remove <think> blocks if present
        $aiResponse = preg_replace('/<think>.*?<\/think>/s', '', $aiResponse);
        $aiResponse = trim($aiResponse);

        // Update History
        $history = $sessionData['history'];
        if (!empty($userMessage)) {
            $history[] = ['user' => $userMessage, 'ai' => $aiResponse, 'timestamp' => time()];
        } else {
            // Initial question
            $history[] = ['user' => '[Started Interview]', 'ai' => $aiResponse, 'timestamp' => time()];
        }
        $sessionData['history'] = $history;
        session()->set('mock_interview', $sessionData);

        // Log AI Usage (Tool ID 4: Mock Interview - per message)
        $this->recordAiUsage(6, ['user' => $userMessage], ['reply' => $aiResponse]);

        return $this->response->setJSON(['reply' => $aiResponse]);
    }

    public function finishMockSession()
    {
        $sessionData = session()->get('mock_interview');
        if (!$sessionData)
            return redirect()->to(base_url('ai-tools/mock-interview'));

        $transcript = "";
        foreach ($sessionData['history'] as $turn) {
            $userText = ($turn['user'] === '[Started Interview]') ? "[Start]" : $turn['user'];
            $transcript .= "Officer: {$turn['ai']}\nApplicant: {$userText}\n\n";
        }

        $settings = $this->getAiSettings();
        $apiKey = $settings['apiKey'];

        $prompt = "Analyze this mock visa interview transcript for {$sessionData['country']} ({$sessionData['visa_type']} visa).
        Return a JSON object with 7 parameters (scores 1-100) and feedback:
        1. 'clarity': Speech clarity and pace.
        2. 'confidence': Lack of fillers and steady delivery.
        3. 'content': Accuracy and persuasiveness of facts.
        4. 'reasoning': Logical connection between answers.
        5. 'language': Vocabulary and grammar.
        6. 'body_language': (Simulate this based on verbal cues like hesitations).
        7. 'passing_potential': Overall assessment.
        
        Also include:
        - 'feedback': General summary.
        - 'q_analysis': Array of objects with {question, correction, score}.
        - 'total_score': Average of parameters.
        
        Transcript:
        {$transcript}";

        $analysis = $this->callOpenRouterForAnalysis($prompt, $apiKey);

        // Save to MockInterviews Table
        $userId = session()->get('user_id');
        if ($this->userExists($userId)) {
            $mockModel = new \App\Models\MockInterviewModel();
            $mockModel->insert([
                'user_id' => $userId,
                'country' => $sessionData['country'],
                'visa_type' => $sessionData['visa_type'],
                'transcript' => json_encode($sessionData['history']),
                'feedback' => json_encode($analysis),
                'score' => $analysis['total_score'] ?? 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Log AI Usage (Tool ID 6: Mock Interview - final analysis)
        $calc = $this->paymentService->calculateFinalPrice(6, null, $userId); // Coupons not usually in session here, but standard price check
        $this->recordAiUsage(6, ['sessions_turns' => count($sessionData['history'] ?? []), 'final_amount' => $calc['final_price'] ?? 0], $analysis);

        // Keep analysis in session for result page display if needed, or pass directly
        session()->remove('mock_interview');

        return view('web/ai/mock-result', [
            'analysis' => $analysis,
            'title' => 'Interview Scorecard | UniHunt',
            'session' => $sessionData
        ]);
    }

    // --- Helpers ---

    private function saveAiDocument($userId, $type, $title, $content, $metadata = [])
    {
        if (!$this->userExists($userId))
            return;

        $docModel = new \App\Models\AiDocumentModel();
        $docModel->insert([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'content' => $content,
            'metadata' => json_encode($metadata),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    private function saveAiSearch($userId, $toolType, $params, $resultId = null)
    {
        if (!$this->userExists($userId))
            return;

        // Check duplication to avoid spamming searches if identical (optional, but good for UI)
        $historyModel = new \App\Models\AiSearchHistoryModel();

        // Simple duplicate check: if same search within last minute
        $recent = $historyModel->where('user_id', $userId)
            ->where('tool_type', $toolType)
            ->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 minute')))
            ->first();

        $encodedParams = json_encode($params);
        if ($recent && $recent['search_params'] === $encodedParams) {
            return; // Skip duplicate
        }

        $historyModel->insert([
            'user_id' => $userId,
            'tool_type' => $toolType,
            'search_params' => $encodedParams,
            'result_id' => $resultId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    private function callOpenRouterForChat($messages, $apiKey)
    {
        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey", "Content-Type: application/json"]);
        $settings = $this->getAiSettings();
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'model' => $settings['model'],
            'messages' => $messages,
            'temperature' => $settings['temperature']
        ]));
        $res = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($res, true);
        return $json['choices'][0]['message']['content'] ?? "Next question?";
    }

    private function callOpenRouterForAnalysis($prompt, $apiKey)
    {
        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey", "Content-Type: application/json"]);

        // Deepseek R1 can be chatty, so we enforce JSON
        $settings = $this->getAiSettings();
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

        // Remove reasoning prefix if it leaks outside JSON
        $content = preg_replace('/^.*?({.*}).*$/s', '$1', $content);

        return json_decode($content, true);
    }

    // --- History Viewers ---

    public function viewDocument($id)
    {
        $userId = session()->get('user_id');
        if (!$userId)
            return redirect()->to(base_url('login'));

        $docModel = new \App\Models\AiDocumentModel();
        $doc = $docModel->find($id);

        if (!$doc || $doc['user_id'] != $userId)
            return redirect()->to(base_url('dashboard'));

        // If Resume, return raw HTML (or specialized view if we refactor). 
        // NOTE: Since resume stores full HTML with layout, echoing it is easiest, or wrap in a basic layout.
        if ($doc['type'] === 'RESUME') {
            return $doc['content'];
        }

        $view = ($doc['type'] === 'SOP') ? 'web/ai/sop-result' : 'web/ai/lor-result';
        $data = [];
        if ($doc['type'] === 'SOP') {
            $meta = json_decode($doc['metadata'], true) ?? [];
            $data = [
                'sop_content' => $doc['content'],
                'title' => 'Your Saved SOP | UniHunt',
                'name' => 'Applicant',
                'country' => $meta['target_country'] ?? '',
                'word_count' => str_word_count(strip_tags($doc['content'])),
                'health_score' => $meta['health_score'] ?? 0
            ];
        } else {
            $meta = json_decode($doc['metadata'], true) ?? [];
            $data = [
                'lor_content' => $doc['content'],
                'title' => 'Your Saved LOR | UniHunt'
            ];
        }
        return view($view, $data);
    }

    public function viewMockInterview($id)
    {
        $userId = session()->get('user_id');
        if (!$userId)
            return redirect()->to(base_url('login'));

        $mockModel = new \App\Models\MockInterviewModel();
        $mock = $mockModel->find($id);
        if (!$mock || $mock['user_id'] != $userId)
            return redirect()->to(base_url('dashboard'));

        return view('web/ai/mock-result', [
            'analysis' => json_decode($mock['feedback'], true),
            'title' => 'Interview Scorecard | History',
            'session' => [
                'country' => $mock['country'],
                'visa_type' => $mock['visa_type'],
                'history' => json_decode($mock['transcript'], true)
            ]
        ]);
    }

    public function viewVisaResult($resultId)
    {
        // Public knowledge base view (cached results)
        $visa = (new \App\Models\VisaKnowledgeBaseModel())->find($resultId);
        if (!$visa)
            return redirect()->to(base_url('dashboard'));

        return view('web/ai/visa-result', $visa);
    }

    public function viewCareerResult($resultId)
    {
        $career = (new \App\Models\CareerPredictionModel())->find($resultId);
        if (!$career)
            return redirect()->to(base_url('dashboard'));

        return view('web/ai/career-result', $career);
    }

    /**
     * AJAX endpoint to check tool price with coupon.
     */
    public function checkPrice()
    {
        $input = $this->request->getJSON(true);
        $toolId = (int) ($input['tool_id'] ?? 0);
        $couponCode = $input['coupon_code'] ?? null;
        $userId = session()->get('user_id');

        $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, $userId);

        if (isset($calc['error'])) {
            return $this->response->setJSON(['error' => $calc['error'], 'csrf_token' => csrf_hash()]);
        }

        // If amount > 0 and payments enabled, create a Razorpay orderId
        $orderId = null;
        $db = \Config\Database::connect();
        $settings = $db->table('site_config')->get()->getResultArray();
        $config = [];
        foreach ($settings as $s) {
            $val = $s['config_value'];
            $decoded = json_decode($val, true);
            $config[$s['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }
        $orderId = null;
        if ($calc['final_price'] > 0 && $this->paymentService->isPaymentEnabled()) {
            $receipt = "REQ_" . uniqid();
            $order = $this->paymentService->createRazorpayOrder($calc['final_price'], $receipt);
            if (isset($order['error'])) {
                return $this->response->setJSON(['error' => $order['error'], 'csrf_token' => csrf_hash()]);
            }
            $orderId = $order['id'];
        }

        $razorpayKey = $this->paymentService->getRazorpayKey();

        return $this->response->setJSON([
            'original_price' => $calc['original_price'],
            'final_price' => $calc['final_price'],
            'discount_amount' => $calc['discount_amount'],
            'status' => $calc['status'],
            'order_id' => $orderId,
            'razorpay_key' => $razorpayKey,
            'csrf_token' => csrf_hash()
        ]);
    }

    /**
     * verify payment and return success
     */
    public function verifyPayment()
    {
        $input = $this->request->getJSON(true);
        $razorpayOrderId = $input['razorpay_order_id'] ?? '';
        $razorpayPaymentId = $input['razorpay_payment_id'] ?? '';
        $razorpaySignature = $input['razorpay_signature'] ?? '';

        $isValid = $this->paymentService->verifySignature($razorpayOrderId, $razorpayPaymentId, $razorpaySignature);

        if (!$isValid) {
            return $this->response->setJSON(['success' => false, 'error' => 'Invalid payment signature']);
        }

        // Return token/success to allow form submission
        return $this->response->setJSON([
            'success' => true,
            'csrf_token' => csrf_hash()
        ]);
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

        // If price > 0, we expect payment fields in POST
        $paymentId = $input['razorpay_payment_id'] ?? null;
        $orderId = $input['razorpay_order_id'] ?? null;
        $signature = $input['razorpay_signature'] ?? null;
        $couponCode = $input['coupon_code'] ?? null;

        // Check for 100% waiver first
        $calc = $this->paymentService->calculateFinalPrice($toolId, $couponCode, session()->get('user_id'));
        if (isset($calc['final_price']) && $calc['final_price'] <= 0) {
            return true; // Proceed for waived/free
        }

        if (!$paymentId || !$orderId || !$signature) {
            return false;
        }

        return $this->paymentService->verifySignature($orderId, $paymentId, $signature);
    }
    // --- AI COUNSELLOR ---

    public function startCounsellorSession()
    {
        $input = $this->request->getPost();

        // 1. Payment/Access Check
        if (!$this->validateAccess(11, $input)) {
            return redirect()->back()->with('error', 'Payment required to start session.');
        }

        $userId = session()->get('user_id');

        // Record Coupon
        if (!empty($input['coupon_code'])) {
            $calc = $this->paymentService->calculateFinalPrice(11, $input['coupon_code'], $userId);
            if (isset($calc['coupon_id'])) {
                $this->paymentService->recordCouponUsage($calc['coupon_id'], (int) $userId, $calc['discount_amount'], $input['razorpay_order_id'] ?? null);
            }
        }

        // 2. Prepare Profile Data
        $profile = [
            'education_level' => $input['education_level'] ?? '',
            'gpa' => $input['gpa'] ?? '',
            'test_scores' => $input['test_scores'] ?? '',
            'gre_gmat' => $input['gre_gmat'] ?? '',
            'preferred_country' => $input['preferred_country'] ?? '',
            'field_of_study' => $input['field_of_study'] ?? '',
            'budget' => $input['budget'] ?? '',
            'intake' => $input['intake'] ?? '',
            'goals' => $input['goals'] ?? ''
        ];

        // 3. Generate Initial Recommendations via AI
        $aiService = new \App\Libraries\AIService();

        // Fetch context data
        $uniModel = new \App\Models\UniversityModel();
        $courseModel = new \App\Models\CourseModel();

        $universities = [];
        if (!empty($profile['preferred_country'])) {
            $universities = $uniModel->select('universities.id, universities.name, countries.name as country, universities.ranking, universities.tuition_fee_min')
                ->join('countries', 'countries.id = universities.country_id')
                ->like('countries.name', $profile['preferred_country'])
                ->where('ranking >', 0)
                ->limit(20)
                ->find();
        }

        // If no specific country found or specified, get top global
        if (empty($universities)) {
            $universities = $uniModel->select('id, name, ranking, tuition_fee_min')
                ->where('ranking >', 0)
                ->orderBy('ranking', 'ASC')
                ->limit(20)
                ->find();
        }

        $courses = $courseModel->select('id, name, level, university_id, tuition_fee')
            ->like('name', $profile['field_of_study'] ?: 'Science')
            ->limit(30)
            ->find();

        $recommendations = $aiService->generateCounsellorRecommendations($profile, $universities, $courses);

        // 4. Create Session
        $sessionModel = new \App\Models\AiCounsellorSessionModel();

        // Calculate Payment Amount for Record
        $calc = $this->paymentService->calculateFinalPrice(11, $input['coupon_code'] ?? null, $userId);

        $sessionId = $sessionModel->insert([
            'user_id' => $userId,
            'student_profile' => json_encode($profile),
            'recommendations' => json_encode($recommendations),
            'conversation_history' => '[]',
            'payment_status' => ($calc['final_price'] <= 0) ? 'waived' : 'paid',
            'razorpay_order_id' => $input['razorpay_order_id'] ?? null,
            'razorpay_payment_id' => $input['razorpay_payment_id'] ?? null,
            'coupon_code' => $input['coupon_code'] ?? null,
            'final_amount' => $calc['final_price'] ?? 0,
            'session_status' => 'active',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Log AI Usage
        if ($userId) {
            $this->recordAiUsage(11, array_merge(['type' => 'counsellor_session', 'field' => $profile['field_of_study'], 'final_amount' => $calc['final_price'] ?? 0], $input), ['session_id' => $sessionId]);
        }

        return redirect()->to(base_url('ai-tools/counsellor-session/' . $sessionId));
    }

    public function viewCounsellorSession($id)
    {
        $sessionModel = new \App\Models\AiCounsellorSessionModel();
        $session = $sessionModel->find($id);

        if (!$session) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Session not found");
        }

        // Basic ACL
        if ($session['user_id'] && $session['user_id'] != session()->get('user_id')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('web/ai/counsellor-chat', [
            'title' => 'AI Counsellor Chat',
            'session' => $session,
            'profile' => json_decode($session['student_profile'], true),
            'recommendations' => json_decode($session['recommendations'], true)
        ]);
    }

    public function counsellorChat()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400);
        }

        $sessionId = $this->request->getPost('session_id');
        $userMessage = $this->request->getPost('message');

        $sessionModel = new \App\Models\AiCounsellorSessionModel();
        $session = $sessionModel->find($sessionId);

        if (!$session || ($session['user_id'] && $session['user_id'] != session()->get('user_id'))) {
            return $this->response->setJSON(['error' => 'Invalid Session']);
        }

        // 1. Update History with User Message
        $sessionModel->addMessage($sessionId, 'user', $userMessage);

        // 2. Call AI
        // Construct context with profile and recent history
        $profile = json_decode($session['student_profile'], true);
        $history = json_decode($session['conversation_history'], true);
        $history[] = ['role' => 'user', 'message' => $userMessage];

        $prompt = "You are a helpful university counsellor. Student Profile: " . json_encode($profile) . "\n\n";
        $prompt .= "Conversation History:\n";
        foreach (array_slice($history, -6) as $msg) {
            $roleName = $msg['role'] === 'user' ? 'Student' : 'Counsellor';
            $prompt .= $roleName . ": " . $msg['message'] . "\n";
        }
        $prompt .= "Counsellor: ";

        $settings = $this->getAiSettings();
        $aiReply = $this->callOpenRouterForChat([['role' => 'user', 'content' => $prompt]], $settings['apiKey']);

        // 3. Update History with AI Reply
        $sessionModel->addMessage($sessionId, 'ai', $aiReply);

        return $this->response->setJSON(['reply' => $aiReply, 'csrf_token' => csrf_hash()]);
    }
}
