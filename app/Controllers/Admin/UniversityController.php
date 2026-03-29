<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UniversityModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\ImportLogModel;

class UniversityController extends BaseController
{
    protected $universityModel;
    protected $countryModel;
    protected $stateModel;

    public function __construct()
    {
        $this->universityModel = new UniversityModel();
        $this->countryModel = new CountryModel();
        $this->stateModel = new StateModel();
        helper(['image']);
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $perPage = 10;

        // Start building the query
        $query = $this->universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, university_images.file_name as main_image')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('university_images', "university_images.university_id = universities.id AND (university_images.image_type = 'banner' OR university_images.is_main = 1)", 'left')
            ->groupBy('universities.id, countries.name, countries.slug, university_images.file_name');

        // Apply Search Filter
        if (!empty($search)) {
            $query->groupStart()
                ->like('universities.name', $search)
                ->orLike('countries.name', $search)
                ->groupEnd();
        }

        // Filter for Uni Rep
        if (session()->get('role_id') == 4) {
            $query->where('universities.id', session()->get('university_id'));
        }

        $data = [
            'title' => 'Manage Universities',
            'universities' => $query->paginate($perPage),
            'pager' => $this->universityModel->pager,
            'search' => $search
        ];

        return view('admin/universities/index', $data);
    }

    public function create()
    {
        if (!$this->checkPermission('create', 'university')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $data = [
            'title' => 'Add University',
            'countries' => $this->countryModel->findAll(),
            'states' => $this->stateModel->findAll(),
        ];
        return view('admin/universities/create', $data);
    }

    public function store()
    {
        if (!$this->checkPermission('create', 'university')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $db = \Config\Database::connect();
        $db->transStart();

        // Duplicate Check
        $existing = $this->universityModel->where('name', $this->request->getPost('name'))
            ->where('country_id', $this->request->getPost('country_id'))
            ->first();

        if ($existing) {
            $db->transRollback();
            return redirect()->back()->with('error', 'University already exists in this country.');
        }

        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'type' => $this->request->getPost('type'),
            'website' => $this->request->getPost('website'),
            'ranking' => $this->request->getPost('ranking') ?: null,
            'stem_available' => $this->request->getPost('stem_available') ? 1 : 0,
            'classification' => $this->request->getPost('classification'),
            'tuition_fee_min' => $this->request->getPost('tuition_fee_min') ?: null,
            'tuition_fee_max' => $this->request->getPost('tuition_fee_max') ?: null,
            'metadata' => json_encode($this->request->getPost('metadata')),
        ];

        $universityId = $this->universityModel->insert($data);

        // Handle Multiple Image Uploads
        if ($this->request->getFileMultiple('images')) {
            $validationRule = [
                'images' => [
                    'label' => 'University Images',
                    'rules' => [
                        'is_image[images]',
                        'mime_in[images,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                        'max_size[images,10240]', // 10MB limit per image
                    ],
                ],
            ];

            if ($this->request->getFileMultiple('images')[0]->isValid()) {
                if (!$this->validate($validationRule)) {
                    $db->transRollback();
                    return redirect()->back()->with('error', $this->validator->getError('images'))->withInput();
                }

                $files = $this->request->getFileMultiple('images');
                $imageModel = new \App\Models\UniversityImageModel();
                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $storedPath = upload_and_convert_webp($file, 'uploads/universities');
                        if (!$storedPath)
                            continue;

                        $imageType = 'gallery';
                        if ($index === 0)
                            $imageType = 'logo';
                        elseif ($index === 1)
                            $imageType = 'banner';

                        $imageModel->insert([
                            'university_id' => $universityId,
                            'file_name' => $storedPath,
                            'image_type' => $imageType,
                            'is_main' => ($index === 0) ? 1 : 0, // Logo is main
                            'uploaded_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Critical Error: Data Transaction failed.');
        }

        return redirect()->to(base_url('admin/universities'))->with('success', 'University added with images.');
    }

    public function editUniversity($id)
    {
        if (!$this->checkPermission('update', 'university', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $university = $this->universityModel->find($id);
        if (!$university) {
            return redirect()->back()->with('error', 'University not found');
        }

        // Decode metadata if it exists
        if (!empty($university['metadata'])) {
            $university['metadata'] = json_decode($university['metadata'], true);
        }

        // Fetch images
        $imageModel = new \App\Models\UniversityImageModel();
        $images = $imageModel->where('university_id', $id)->findAll();

        $data = [
            'title' => 'Edit University',
            'countries' => $this->countryModel->findAll(),
            'states' => $this->stateModel->findAll(),
            'university' => $university,
            'images' => $images
        ];
        return view('admin/universities/edit', $data);
    }

    public function update($id)
    {
        if (!$this->checkPermission('update', 'university', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $db = \Config\Database::connect();
        $db->transStart();

        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id') ?: null,
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'type' => $this->request->getPost('type'),
            'website' => $this->request->getPost('website'),
            'ranking' => $this->request->getPost('ranking') ?: null,
            'stem_available' => $this->request->getPost('stem_available') ? 1 : 0,
            'classification' => $this->request->getPost('classification'),
            'tuition_fee_min' => $this->request->getPost('tuition_fee_min') ?: null,
            'tuition_fee_max' => $this->request->getPost('tuition_fee_max') ?: null,
            'metadata' => json_encode($this->request->getPost('metadata')),
        ];

        $this->universityModel->update($id, $data);

        // Handle Multiple Image Uploads
        if ($this->request->getFileMultiple('images')) {
            $validationRule = [
                'images' => [
                    'label' => 'University Images',
                    'rules' => [
                        'is_image[images]',
                        'mime_in[images,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                        'max_size[images,10240]', // 10MB limit per image
                    ],
                ],
            ];

            if ($this->request->getFileMultiple('images')[0]->isValid()) {
                if (!$this->validate($validationRule)) {
                    $db->transRollback();
                    return redirect()->back()->with('error', $this->validator->getError('images'))->withInput();
                }

                $files = $this->request->getFileMultiple('images');
                $imageModel = new \App\Models\UniversityImageModel();

                // Check if any main image exists
                $existingMain = $imageModel->where('university_id', $id)->where('is_main', 1)->first();
                $isFirst = !$existingMain;

                foreach ($files as $index => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $storedPath = upload_and_convert_webp($file, 'uploads/universities');
                        if (!$storedPath)
                            continue;

                        $imageType = 'gallery';
                        if ($index === 0)
                            $imageType = 'logo';
                        elseif ($index === 1)
                            $imageType = 'banner';

                        $imageModel->insert([
                            'university_id' => $id,
                            'file_name' => $storedPath,
                            'image_type' => $imageType,
                            'is_main' => $isFirst ? 1 : 0,
                            'uploaded_at' => date('Y-m-d H:i:s')
                        ]);
                        $isFirst = false;
                    }
                }
            }
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Critical Error: Data Transaction failed.');
        }

        return redirect()->to(base_url('admin/universities'))->with('success', 'University updated successfully.');
    }

    public function uploadBulk()
    {
        // Only Admin and Counsellor can upload bulk
        if (session()->get('role_id') == 4) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $file = $this->request->getFile('bulk_csv');
        if (!$file->isValid())
            return redirect()->back()->with('error', 'Invalid file');

        $csvFile = fopen($file->getTempName(), 'r');
        $headers = fgetcsv($csvFile);
        if (!$headers)
            return redirect()->back()->with('error', 'CSV file is empty');

        // Clean headers
        $headers = array_map(function ($h) {
            return strtolower(trim($h));
        }, $headers);

        // Define column mapping
        $mapping = [
            'country_id' => ['country_id', 'country'],
            'name' => ['name', 'university_name', 'university'],
            'type' => ['type', 'university_type'],
            'website' => ['website', 'university_link', 'link', 'url'],
            'ranking' => ['ranking', 'qs_ranking', 'rank'],
            'stem_available' => ['stem', 'stem_available'],
            'classification' => ['classification', 'international_domestic'],
            'tuition_fee_min' => ['tuition_fee_min', 'fee_min', 'min_fee'],
            'tuition_fee_max' => ['tuition_fee_max', 'fee_max', 'max_fee'],
        ];

        $success = 0;
        $failed = 0;
        while (($row = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
            try {
                $data = [];
                $metadata = [];

                foreach ($headers as $index => $header) {
                    $value = isset($row[$index]) ? trim($row[$index]) : null;
                    $mapped = false;

                    foreach ($mapping as $field => $aliases) {
                        if (in_array($header, $aliases)) {
                            if ($field == 'stem_available') {
                                $data[$field] = (strtoupper($value) == 'YES' || $value == '1') ? 1 : 0;
                            } else {
                                $data[$field] = $value;
                            }
                            $mapped = true;
                            break;
                        }
                    }

                    if (!$mapped && $value !== null && $value !== '') {
                        $metadata[$header] = $value;
                    }
                }

                if (!empty($metadata)) {
                    $data['metadata'] = json_encode($metadata);
                }

                if (isset($data['name'])) {
                    // Slug and Duplicate Check
                    $data['slug'] = url_title($data['name'], '-', true);

                    $existing = $this->universityModel->where('name', $data['name']);
                    if (isset($data['country_id']))
                        $existing->where('country_id', $data['country_id']);

                    if (!$existing->first()) {
                        $this->universityModel->insert($data);
                        $success++;
                    } else {
                        $failed++;
                    }
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
            }
        }
        fclose($csvFile);

        $logModel = new ImportLogModel();
        $logModel->insert(['entity' => 'university', 'total' => $success + $failed, 'success' => $success, 'failed' => $failed]);

        return redirect()->back()->with('success', "Import complete: $success success, $failed failed.");
    }

    public function generateDetails()
    {
        $input = $this->request->getJSON(true);
        $name = $input['name'] ?? '';
        $countryId = $input['country_id'] ?? null;

        if (empty($name)) {
            return $this->response->setJSON(['error' => 'University name is required', 'csrf_token' => csrf_hash()]);
        }

        // Fetch API Key
        $apiKey = env('openai_api_key_paid') ?: env('openai_api_key');
        if (substr($apiKey, 0, 9) !== 'sk-or-v1-') {
            $apiKey = getenv('openai_api_key_paid') ?: getenv('openai_api_key');
        }

        // Fallback to DB if .env is empty
        if (empty($apiKey) || trim($apiKey) === '') {
            $db = \Config\Database::connect();
            $query = $db->table('site_config')->where('config_key', 'openai_api_key')->get();
            $res = $query->getRowArray();
            $apiKey = $res['config_value'] ?? ($config['openai_api_key'] ?? '');
        }

        log_message('debug', 'Using API Key Prefix: ' . substr($apiKey, 0, 15) . '...');

        if (empty($apiKey)) {
            return $this->response->setJSON(['error' => 'AI API Key is not configured in .env.', 'csrf_token' => csrf_hash()]);
        }

        // Check for existing request (Cache logic)
        $aiRequestModel = new \App\Models\AiRequestModel();
        $existingRequest = $aiRequestModel->where('tool_id', 8)
            ->groupStart()
            ->like('input_data', '"name":"' . str_replace('"', '\\"', $name) . '"')
            ->groupEnd()
            ->orderBy('id', 'DESC')
            ->first();

        if ($existingRequest) {
            $cachedData = json_decode($existingRequest['output_data'], true);
            if (!empty($cachedData)) { // Only return if valid array/object
                $cachedData['csrf_token'] = csrf_hash();
                $cachedData['from_cache'] = true;
                return $this->response->setJSON($cachedData);
            }
        }

        // If countryId is missing, let AI deduce it first to fetch requirements
        if (!$countryId) {
            $countryGuess = $this->callOpenRouter("Identify the country where '$name' is located. Return ONLY the country name.", $apiKey);
            $countryGuess = trim(preg_replace('/[^a-zA-Z\s]/', '', $countryGuess)); // basic clean
            if (!empty($countryGuess)) {
                $countryModel = new \App\Models\CountryModel();
                $c = $countryModel->like('name', $countryGuess)->first();
                if ($c) {
                    $countryId = $c['id'];
                }
            }
        }

        // Fetch dynamic requirements if country is known
        $reqPrompt = "";
        $reqFields = [];
        if ($countryId) {
            $paramModel = new \App\Models\RequirementParameterModel();
            $params = $paramModel->whereIn('applies_to', ['University', 'Both'])
                ->groupStart()
                ->where('country_id', NULL)
                ->orWhere('country_id', $countryId)
                ->groupEnd()
                ->findAll();

            if (!empty($params)) {
                $reqPrompt = "Also provide values for these specific requirements in a 'requirements' object (key=code):";
                foreach ($params as $p) {
                    $reqPrompt .= "\n- {$p['code']}: {$p['label']} (Type: {$p['type']})";
                    $reqFields[] = $p['code'];
                }
            }
        }

        $prompt = "Provide comprehensive details for '{$name}' in valid JSON format. 
        Fields required:
        - website: official website URL
        - type: 'public' or 'private'
        - country: Full country name
        - state: State or province name
        - ranking: Current QS or World ranking (integer only)
        - tuition_min: Approximate minimum yearly tuition fee in USD (number only)
        - tuition_max: Approximate maximum yearly tuition fee in USD (number only)
        - ratio: Student-faculty ratio (e.g., '15:1')
        - map_url: A Google Maps embed URL for the university location
        - about: A professional 2-sentence marketing summary.
        - living_expenses: Approximate monthly living expenses (e.g., '$1,200/month').
        
        {$reqPrompt}

        Return ONLY valid JSON. No other text.";

        $response = $this->callOpenRouter($prompt, $apiKey);

        // Fallback to second key if first one fails
        if (empty($response)) {
            $backupKey = ($apiKey === env('openai_api_key_paid')) ? env('openai_api_key') : env('openai_api_key_paid');
            if (!empty($backupKey) && $backupKey !== $apiKey) {
                log_message('debug', 'AI Primary Key failed (check logs for details), retrying with backup key...');
                $response = $this->callOpenRouter($prompt, $backupKey);
            }
        }

        if (empty($response) || strpos($response, 'ERROR:') === 0) {
            $errorMsg = empty($response) ? 'AI Service failed' : substr($response, 7);
            return $this->response->setJSON([
                'error' => 'AI Error: ' . $errorMsg,
                'csrf_token' => csrf_hash()
            ]);
        }

        // Clean the response if it contains markdown code blocks or other junk
        $jsonResponse = $response;
        if (preg_match('/\{(?:[^{}]|(?R))*\}/s', $response, $matches)) {
            $jsonResponse = $matches[0];
        } else {
            $jsonResponse = preg_replace('/^```json\s*|\s*```$/i', '', trim($response));
        }

        // Second pass: remove common AI JSON artifacts (like trailing commas before closing braces)
        $jsonResponse = preg_replace('/,\s*([\]\}])/', '$1', $jsonResponse);

        $data = json_decode($jsonResponse, true);

        if (!$data) {
            log_message('error', 'AI Response Parsing Failed. Raw Response: ' . $response . ' | Cleaned JSON: ' . $jsonResponse);
            return $this->response->setJSON([
                'error' => 'Failed to parse AI response',
                'raw' => $response,
                'csrf_token' => csrf_hash()
            ]);
        }

        // Log AI Usage (Tool ID 8: University Discovery)
        $this->recordAiUsage(8, ['name' => $name, 'country_id' => $countryId], $data);

        $data['csrf_token'] = csrf_hash();
        return $this->response->setJSON($data);
    }

    private function callOpenRouter($prompt, $apiKey)
    {
        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "HTTP-Referer: " . base_url(),
            "X-Title: Unihunt App",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $payload = [
            'model' => 'arcee-ai/trinity-large-preview:free',
            'messages' => [['role' => 'user', 'content' => $prompt]],
            'temperature' => 0.7
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            log_message('error', 'OpenRouter CURL Error: ' . $err);
            return "";
        }

        $result = json_decode($response, true);

        if (isset($result['error'])) {
            $errorMsg = $result['error']['message'] ?? 'Unknown OpenRouter Error';
            log_message('error', 'OpenRouter API Error: ' . $errorMsg);
            // Return the error message so the caller can display it
            return "ERROR: " . $errorMsg;
        }

        return $result['choices'][0]['message']['content'] ?? "";
    }

    public function scrapeImages()
    {
        $university = $this->request->getPost('name');
        if (empty($university)) {
            return $this->response->setJSON(['error' => 'University name is required', 'csrf_token' => csrf_hash()]);
        }

        $limits = [
            'logo' => 1,
            'campus' => 9
        ];

        $queries = [
            'logo' => $university . ' official logo transparent',
            'campus' => $university . ' campus building'
        ];

        $baseDir = 'uploads/temp_scraping/' . url_title($university, '_', true);
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0777, true);
        }

        $downloadedImages = [];

        foreach ($queries as $type => $query) {
            $searchUrl = "https://www.bing.com/images/search?q=" . urlencode($query) . "&form=HDRSC2";

            $ch = curl_init($searchUrl);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ]);
            $html = curl_exec($ch);
            curl_close($ch);

            if ($html === false) {
                continue;
            }

            preg_match_all('/murl&quot;:&quot;(.*?)&quot;/', $html, $matches);

            if (empty($matches[1])) {
                continue;
            }

            $images = array_unique($matches[1]);
            $count = 0;

            foreach ($images as $imgUrl) {
                if ($count >= $limits[$type])
                    break;

                $ext = pathinfo(parse_url($imgUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                if (!$ext || !in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                    $ext = 'jpg';
                }

                $fileName = "{$type}_" . ($count + 1) . ".$ext";
                $filePath = $baseDir . '/' . $fileName;

                if ($this->downloadImage($imgUrl, $filePath)) {
                    $newPath = convert_file_to_webp($filePath);
                    $downloadedImages[] = [
                        'url' => base_url($newPath),
                        'fileName' => basename($newPath),
                        'type' => $type
                    ];
                    $count++;
                }

                usleep(100000); // 0.1 sec delay
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'images' => $downloadedImages,
            'csrf_token' => csrf_hash()
        ]);
    }

    public function deleteImage($imageId)
    {
        $imageModel = new \App\Models\UniversityImageModel();
        $image = $imageModel->find($imageId);

        if (!$image) {
            return $this->response->setJSON(['error' => 'Image not found', 'csrf_token' => csrf_hash()]);
        }

        // Check if user has permission to update this university
        if (!$this->checkPermission('update', 'university', $image['university_id'])) {
            return $this->response->setJSON(['error' => 'Permission denied', 'csrf_token' => csrf_hash()]);
        }

        // Don't delete if it's the main image and there are others
        // (Optional: let user delete it but inform them to set another one)

        // Remove file from disk
        if (file_exists($image['file_name'])) {
            unlink($image['file_name']);
        }

        $imageModel->delete($imageId);

        return $this->response->setJSON(['success' => true, 'csrf_token' => csrf_hash()]);
    }

    public function delete($id)
    {
        if (!$this->checkPermission('delete', 'university', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Delete associated images (files + db records)
        $imageModel = new \App\Models\UniversityImageModel();
        $images = $imageModel->where('university_id', $id)->findAll();
        foreach ($images as $img) {
            if (file_exists($img['file_name'])) {
                unlink($img['file_name']);
            }
        }
        $imageModel->where('university_id', $id)->delete();

        // 2. Delete associated courses
        $courseModel = new \App\Models\CourseModel();
        $courseModel->where('university_id', $id)->delete();

        // 3. Delete university requirements
        $uniReqModel = new \App\Models\UniversityRequirementModel();
        $uniReqModel->where('university_id', $id)->delete();

        // 4. Delete reviews
        $reviewModel = new \App\Models\ReviewModel();
        $reviewModel->where('university_id', $id)->delete();

        // 5. Update associated blogs (set university_id to null)
        $db->table('blogs')->where('university_id', $id)->update(['university_id' => null]);

        // 6. Update associated users (reset Uni Reps to Standard Students)
        $db->table('users')->where('university_id', $id)->update([
            'university_id' => null,
            'role_id' => 2 // Student
        ]);

        // 7. Finally delete the university
        $this->universityModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Critical Error: Failed to delete university and associated data.');
        }

        return redirect()->to(base_url('admin/universities'))->with('success', 'University and all associated data deleted successfully.');
    }

    private function downloadImage($url, $path)
    {

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            CURLOPT_TIMEOUT => 15
        ]);
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data) {
            return file_put_contents($path, $data) !== false;
        }

        return false;
    }
}
