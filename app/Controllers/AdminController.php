<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AiDocumentModel;
use App\Models\MockInterviewModel;
use Config\Database;

class AdminController extends BaseController
{
    private $db;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Simple Admin Check (For MVP, assuming role_id 1 is admin or just basic auth)
        if (!session()->get('isLoggedIn')) {
            // Ideally redirect to login
            header('Location: ' . base_url('login'));
            exit;
        }

        // In a real app, verify role_id == 1 here.

        $this->db = Database::connect();
        helper(['image']);
    }

    public function index()
    {
        $roleId = session()->get('role_id');
        $uniId = session()->get('university_id');

        // --- UNIVERSITY REPRESENTATIVE DASHBOARD ---
        if ($roleId == 4) {
            $courseModel = new \App\Models\CourseModel();
            $uniModel = new \App\Models\UniversityModel();

            $myUni = null;
            if ($uniId) {
                $myUni = $uniModel->find($uniId);
                // Safety check: if find() returns array of arrays
                if (!empty($myUni) && isset($myUni[0]) && is_array($myUni[0])) {
                    $myUni = $myUni[0];
                }
            }

            $totalCourses = ($uniId) ? $courseModel->where('university_id', $uniId)->countAllResults() : 0;

            return view('admin/dashboard_uni_rep', [
                'title' => 'University Dashboard | UniHunt',
                'university' => $myUni,
                'stats' => [
                    'courses' => $totalCourses,
                ]
            ]);
        }

        // --- SHARED STATS (Admin & Counsellor) ---
        $userModel = new UserModel();
        $totalUsers = $userModel->countAll();

        $docModel = new AiDocumentModel();
        $totalDocs = $docModel->countAll();

        $mockModel = new MockInterviewModel();
        $totalMocks = $mockModel->countAll();

        $aiRequestModel = new \App\Models\AiRequestModel();
        $totalAiRequests = $aiRequestModel->countAll();

        $uniModel = new \App\Models\UniversityModel();
        $totalUnis = $uniModel->countAll();

        $courseModel = new \App\Models\CourseModel();
        $totalCourses = $courseModel->countAll();

        $visitorModel = new \App\Models\VisitorModel();
        $totalVisitors = $visitorModel->countAll();

        // Coupon Usage Stats (Admin Only generally, but fetching simplifies code structure)
        $couponModel = new \App\Models\CouponModel();
        $totalCouponUsage = $couponModel->selectSum('usage_count')->first()['usage_count'] ?? 0;

        // Ad Revenue
        $adModel = new \App\Models\AdsModel();
        $totalAdRevenue = $adModel->where('status', 'active')->selectSum('price_paid')->first()['price_paid'] ?? 0;

        $thirtyDaysAgo = date('Y-m-d H:i:s', strtotime('-30 days'));
        $totalVisitors30Days = $visitorModel->where('visited_at >=', $thirtyDaysAgo)->countAllResults();

        $countryStats = $visitorModel->select('country, COUNT(*) as count')
            ->where('visited_at >=', $thirtyDaysAgo)
            ->groupBy('country')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->findAll();

        $mobileVisitors = $visitorModel->where('visited_at >=', $thirtyDaysAgo)
            ->groupStart()
            ->like('user_agent', 'Mobi')
            ->orLike('user_agent', 'Android')
            ->orLike('user_agent', 'iPhone')
            ->groupEnd()
            ->countAllResults();
        $desktopVisitors = max(0, $totalVisitors30Days - $mobileVisitors);

        $recentVisitors = $visitorModel->orderBy('visited_at', 'DESC')->limit(10)->findAll();

        $interestModel = new \App\Models\DestinationInterestModel();
        $interestStats = $interestModel->select('country_slug, COUNT(*) as count')
            ->where('created_at >=', $thirtyDaysAgo)
            ->groupBy('country_slug')
            ->orderBy('count', 'DESC')
            ->findAll();

        $statsData = [
            'users' => $totalUsers,
            'documents' => $totalDocs,
            'interviews' => $totalMocks,
            'ai_usage' => $totalAiRequests,
            'universities' => $totalUnis,
            'courses' => $totalCourses,
            'visitors' => $totalVisitors,
            'coupon_usage' => $totalCouponUsage,
            'ad_revenue' => $totalAdRevenue
        ];

        $visitorsData = [
            'total_30days' => $totalVisitors30Days,
            'countries' => $countryStats,
            'devices' => [
                'mobile' => $mobileVisitors,
                'desktop' => $desktopVisitors
            ],
            'recent' => $recentVisitors,
            'destinations' => $interestStats
        ];

        // --- COUNSELLOR DASHBOARD ---
        if ($roleId == 3) {
            return view('admin/dashboard_counsellor', [
                'title' => 'Counsellor Dashboard | UniHunt',
                'stats' => $statsData,
                'visitors' => $visitorsData
            ]);
        }

        // --- ADMIN DASHBOARD ---
        return view('admin/dashboard', [
            'title' => 'Admin Dashboard | UniHunt',
            'stats' => $statsData,
            'visitors' => $visitorsData
        ]);
    }

    // --- USERS ---
    public function users()
    {
        $userModel = new UserModel();
        $search = $this->request->getVar('search');

        if ($search) {
            $userModel->groupStart()
                ->like('users.name', $search)
                ->orLike('users.email', $search)
                ->groupEnd();
        }

        $roleModel = new \App\Models\RoleModel();
        $uniModel = new \App\Models\UniversityModel();

        $data = [
            'title' => 'Manage Users | Admin',
            'users' => $userModel->select('users.*, roles.name as role_name, universities.name as university_name')
                ->join('roles', 'roles.id = users.role_id', 'left')
                ->join('universities', 'universities.id = users.university_id', 'left')
                ->orderBy('created_at', 'DESC')->paginate(20),
            'pager' => $userModel->pager->only(['search']),
            'search' => $search,
            'roles' => $roleModel->findAll(),
            'universities' => $uniModel->select('id, name')->orderBy('name', 'ASC')->findAll()
        ];

        return view('admin/users', $data);
    }

    public function update_user_role()
    {
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');
        $uniId = $this->request->getPost('university_id'); // Optional

        if (!$userId || !$roleId)
            return redirect()->back()->with('error', 'Invalid parameters');

        $userModel = new UserModel();
        $userModel->update($userId, [
            'role_id' => $roleId,
            'university_id' => ($roleId == 4) ? $uniId : null // Only set Uni ID if role is Uni Rep (4)
        ]);

        return redirect()->back()->with('message', 'User role updated successfully.');
    }

    public function update_user_status()
    {
        $userId = $this->request->getPost('user_id');
        $status = $this->request->getPost('status'); // active, blocked

        if (!$userId || !$status)
            return redirect()->back()->with('error', 'Invalid parameters');

        $userModel = new UserModel();
        $userModel->update($userId, ['status' => $status]);

        if ($this->request->hasHeader('HX-Request')) {
            // Return updated table
            $users = $userModel->orderBy('created_at', 'DESC')->paginate(10);
            $pager = $userModel->pager;
            return view('admin/users_table', [
                'users' => $users,
                'pager' => $pager
            ]);
        }

        return redirect()->back()->with('message', 'User status updated to ' . $status);
    }

    // --- ROLE REQUESTS ---
    public function role_requests()
    {
        if (session()->get('role_id') != 1) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $roleRequestModel = new \App\Models\RoleRequestModel();

        $requests = $roleRequestModel->select('role_requests.*, users.name as user_name, users.email as user_email, roles.name as requested_role_name')
            ->join('users', 'users.id = role_requests.user_id', 'left')
            ->join('roles', 'roles.id = role_requests.requested_role_id', 'left')
            ->orderBy('role_requests.created_at', 'desc')
            ->paginate(20);

        $data = [
            'title' => 'Role Requests | Admin',
            'requests' => $requests,
            'pager' => $roleRequestModel->pager
        ];

        return view('admin/role_requests', $data);
    }

    public function approve_role_request($id)
    {
        if (session()->get('role_id') != 1)
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');

        $roleRequestModel = new \App\Models\RoleRequestModel();
        $userModel = new UserModel();

        $request = $roleRequestModel->find($id);
        if (!$request || $request['status'] != 'pending') {
            return redirect()->back()->with('error', 'Invalid or already processed request.');
        }

        // Update user role
        $userModel->update($request['user_id'], ['role_id' => $request['requested_role_id']]);

        // Update request status
        $roleRequestModel->update($id, ['status' => 'approved']);

        return redirect()->back()->with('message', 'Role request approved successfully.');
    }

    public function reject_role_request($id)
    {
        if (session()->get('role_id') != 1)
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');

        $roleRequestModel = new \App\Models\RoleRequestModel();

        $request = $roleRequestModel->find($id);
        if (!$request || $request['status'] != 'pending') {
            return redirect()->back()->with('error', 'Invalid or already processed request.');
        }

        // Update request status
        $roleRequestModel->update($id, ['status' => 'rejected']);

        return redirect()->back()->with('message', 'Role request rejected.');
    }

    public function payments()
    {
        $aiRequestModel = new \App\Models\AiRequestModel();
        $toolModel = new \App\Models\AiToolModel();

        $search = $this->request->getVar('search');
        $status = $this->request->getVar('status');
        $toolId = $this->request->getVar('tool_id');

        // Build the main query for pagination
        $query = $aiRequestModel->select('ai_requests.*, ai_tools.name as tool_name, users.name as user_name, users.email as user_email')
            ->join('ai_tools', 'ai_tools.id = ai_requests.tool_id')
            ->join('users', 'users.id = ai_requests.user_id', 'left');

        if ($search) {
            $query->groupStart()
                ->like('users.name', $search)
                ->orLike('users.email', $search)
                ->orLike('ai_requests.razorpay_payment_id', $search)
                ->orLike('ai_requests.razorpay_order_id', $search)
                ->groupEnd();
        }

        if ($status)
            $query->where('ai_requests.payment_status', $status);
        if ($toolId)
            $query->where('ai_requests.tool_id', $toolId);

        // For stats, we need a fresh query to avoid "Not unique table/alias" error
        $statsModel = new \App\Models\AiRequestModel();
        $statsQuery = $statsModel->select('ai_requests.payment_status, ai_requests.final_amount')
            ->join('users', 'users.id = ai_requests.user_id', 'left');

        if ($search) {
            $statsQuery->groupStart()
                ->like('users.name', $search)
                ->orLike('users.email', $search)
                ->orLike('ai_requests.razorpay_payment_id', $search)
                ->orLike('ai_requests.razorpay_order_id', $search)
                ->groupEnd();
        }
        if ($status)
            $statsQuery->where('ai_requests.payment_status', $status);
        if ($toolId)
            $statsQuery->where('ai_requests.tool_id', $toolId);

        $allStats = $statsQuery->findAll();

        $totalRev = array_sum(array_column($allStats, 'final_amount'));
        $paidCount = count(array_filter($allStats, fn($p) => $p['payment_status'] === 'paid'));
        $waivedCount = count(array_filter($allStats, fn($p) => $p['payment_status'] === 'waived'));

        $payments = $query->orderBy('ai_requests.created_at', 'DESC')->paginate(20);

        $data = [
            'title' => 'AI Tool Payments | Admin Panel',
            'payments' => $payments,
            'pager' => $aiRequestModel->pager->only(['search', 'status', 'tool_id']),
            'tools' => $toolModel->orderBy('name', 'ASC')->findAll(),
            'stats' => [
                'revenue' => $totalRev,
                'paid' => $paidCount,
                'waived' => $waivedCount
            ],
            'search' => $search,
            'currentStatus' => $status,
            'currentToolId' => $toolId,
            'active_menu' => 'payments'
        ];

        return view('admin/payments', $data);
    }

    // --- SETTINGS ---
    public function settings()
    {
        // Load config from site_config table (key-value)
        $builder = $this->db->table('site_config');
        $configs = $builder->get()->getResultArray();

        $settings = [];
        foreach ($configs as $c) {
            $val = $c['config_value'];
            $decoded = json_decode($val, true);
            $settings[$c['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }

        // Ensure model identifier has a fallback for the UI display
        if (empty($settings['ai_model'])) {
            $settings['ai_model'] = env('ai_model') ?: 'google/gemini-2.0-flash-001';
        }

        // Fetch AI Tools Pricing
        $aiTools = $this->db->table('ai_tools')->get()->getResultArray();

        return view('admin/settings', [
            'title' => 'Site Settings | Admin',
            'settings' => $settings,
            'aiTools' => $aiTools
        ]);
    }

    public function save_settings()
    {
        $data = $this->request->getPost();
        $builder = $this->db->table('site_config');

        // Handle File Uploads (Logo, Favicon)
        $info = ['site_name', 'meta_description', 'contact_email', 'logo_url', 'favicon_url'];

        if ($file = $this->request->getFile('logo')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $storedPath = upload_and_convert_webp($file, 'uploads/settings');
                if ($storedPath) {
                    $data['logo_url'] = $storedPath;
                }
            }
        }

        if ($file = $this->request->getFile('favicon')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $storedPath = upload_and_convert_webp($file, 'uploads/settings');
                if ($storedPath) {
                    $data['favicon_url'] = $storedPath;
                }
            }
        }

        // Handle Checkboxes (set to 0 if not present in POST)
        $checkboxFields = ['payments_enabled', 'razorpay_live_mode'];
        foreach ($checkboxFields as $field) {
            if (!isset($data[$field])) {
                $data[$field] = '0';
            }
        }

        // Handle AI Tool Prices
        if (isset($data['ai_tool_prices']) && is_array($data['ai_tool_prices'])) {
            $toolModel = new \App\Models\AiToolModel();
            foreach ($data['ai_tool_prices'] as $toolId => $price) {
                $toolModel->update($toolId, ['price' => trim($price)]);
            }
            unset($data['ai_tool_prices']);
        }

        foreach ($data as $key => $val) {
            // Skip CSRF/Honeypot
            if (in_array($key, ['csrf_test_name', 'honeypot']))
                continue;

            // Reset builder for each iteration
            $builder = $this->db->table('site_config');

            // Upsert
            $exists = $builder->where('config_key', $key)->countAllResults();

            // Reset builder again for the write operation
            $builder = $this->db->table('site_config');

            if ($exists) {
                $builder->where('config_key', $key)->update(['config_value' => json_encode($val)]);
            } else {
                $builder->insert(['config_key' => $key, 'config_value' => json_encode($val)]);
            }
        }

        if ($this->request->hasHeader('HX-Request')) {
            return '<div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200 flex items-center gap-2" hx-swap-oob="afterbegin:#settings-form">
            <span class="material-symbols-outlined">check_circle</span>
            Settings updated successfully.
        </div>';
        }

        return redirect()->to(base_url('admin/settings'))->with('message', 'Settings updated.');
    }

    public function generate_settings_ai()
    {
        $prompt = "Write a professional, SEO-friendly meta description for an education portal called UniHunt that helps students find universities abroad. Max 160 characters.";

        // Use same logic as generate_seo but simplified
        // Prioritize .env as requested by user
        $apiKey = env('openai_api_key_paid') ?: env('openai_api_key');

        // Fallback to DB if .env is empty
        if (empty($apiKey)) {
            $configToken = $this->db->table('site_config')->where('config_key', 'openai_api_key')->get()->getRowArray();
            if ($configToken) {
                $val = $configToken['config_value'];
                $decoded = json_decode($val, true);
                $apiKey = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
            }
        }
        $apiKey = trim($apiKey ?? "", '"\' ');

        $configModel = $this->db->table('site_config')->where('config_key', 'ai_model')->get()->getRowArray();
        if ($configModel) {
            $val = $configModel['config_value'];
            $decoded = json_decode($val, true);
            $model = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }
        
        // Fallback to .env for model
        if (empty($model) || trim($model) === '') {
            $model = env('ai_model') ?: 'google/gemini-2.0-flash-001';
        }
        $model = trim($model, '"\' ');

        $payload = [
            'model' => $model,
            'messages' => [['role' => 'user', 'content' => $prompt]]
        ];

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
            "HTTP-Referer: " . base_url(),
            "X-Title: UniHunt_Admin"
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        $text = $response['choices'][0]['message']['content'] ?? 'University Finder for International Students.';

        return $this->response->setJSON([
            'description' => trim($text, '"'),
            'csrf_token' => csrf_hash()
        ]);
    }

    // --- BLOGS ---
    public function blogs()
    {
        // Uni Reps cannot access blogs
        if (session()->get('role_id') == 4) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $blogModel = new \App\Models\BlogModel();
        $search = $this->request->getVar('search');

        if ($search) {
            $blogModel->groupStart()
                ->like('title', $search)
                ->orLike('content', $search)
                ->groupEnd();
        }

        $data = [
            'title' => 'Manage Blogs | Admin',
            'blogs' => $blogModel->orderBy('created_at', 'DESC')->paginate(20),
            'pager' => $blogModel->pager->only(['search']),
            'search' => $search
        ];

        return view('admin/blogs/index', $data);
    }

    public function create_blog()
    {
        // Uni Reps cannot access blogs
        if (session()->get('role_id') == 4) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $uniModel = new \App\Models\UniversityModel();
        $universities = $uniModel->select('id, name')->orderBy('name', 'ASC')->findAll();

        return view('admin/blogs/create', [
            'title' => 'Create Blog | Admin',
            'universities' => $universities
        ]);
    }

    public function store_blog()
    {
        // Uni Reps cannot access blogs
        if (session()->get('role_id') == 4) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');
        $status = $this->request->getPost('status');
        $category = $this->request->getPost('category') ?? 'general';
        $university_id = $this->request->getPost('university_id');
        $slug = mb_url_title($title, '-', true);

        // Handle Image Upload for General Blogs
        $featured_image = null;
        if ($category === 'general') {
            $file = $this->request->getFile('featured_image');
            if ($file && $file->isValid()) {
                $validationRule = [
                    'featured_image' => [
                        'label' => 'Featured Image',
                        'rules' => [
                            'uploaded[featured_image]',
                            'is_image[featured_image]',
                            'mime_in[featured_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[featured_image,5120]',
                        ],
                    ],
                ];

                if (!$this->validate($validationRule)) {
                    return redirect()->back()->with('error', $this->validator->getError('featured_image'))->withInput();
                }

                if (!$file->hasMoved()) {
                    $storedPath = upload_and_convert_webp($file, 'uploads/blogs');
                    if ($storedPath) {
                        $featured_image = $storedPath;
                    }
                }
            }
        } else {
            // For University blogs, we link to the university. 
            // We might auto-fetch the university's main image later for display, 
            // or we could specifically select one here if we had an image picker.
            // For now, we trust the 'university_id' link.
        }

        $data = [
            'author_id' => session()->get('user_id'),
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status,
            'category' => $category,
            'university_id' => ($category === 'university' && !empty($university_id)) ? $university_id : null,
            'featured_image' => $featured_image,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'blog_category' => $this->request->getPost('blog_category'),
            'blog_tags' => $this->request->getPost('blog_tags'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('blogs')->insert($data);
        return redirect()->to(base_url('admin/blogs'));
    }

    public function edit_blog($id)
    {
        // Uni Reps cannot access blogs
        if (session()->get('role_id') == 4) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $blogModel = new \App\Models\BlogModel();
        $blog = $blogModel->find($id);

        if (!$blog) {
            return redirect()->to(base_url('admin/blogs'))->with('error', 'Blog not found');
        }

        $uniModel = new \App\Models\UniversityModel();
        $universities = $uniModel->select('id, name')->orderBy('name', 'ASC')->findAll();

        return view('admin/blogs/edit', [
            'title' => 'Edit Blog | Admin',
            'blog' => $blog,
            'universities' => $universities
        ]);
    }

    public function update_blog($id)
    {
        // Uni Reps cannot access blogs
        if (session()->get('role_id') == 4) {
            return redirect()->to(base_url('admin'))->with('error', 'Permission denied.');
        }

        $blogModel = new \App\Models\BlogModel();
        $blog = $blogModel->find($id);

        if (!$blog)
            return redirect()->back();

        $title = $this->request->getPost('title');
        $content = $this->request->getPost('content');
        $status = $this->request->getPost('status');
        $category = $this->request->getPost('category') ?? 'general';
        $university_id = $this->request->getPost('university_id');
        $slug = mb_url_title($title, '-', true);

        // Handle Image Upload
        $featured_image = $blog['featured_image'];
        if ($category === 'general') {
            $file = $this->request->getFile('featured_image');
            if ($file && $file->isValid()) {
                $validationRule = [
                    'featured_image' => [
                        'label' => 'Featured Image',
                        'rules' => [
                            'is_image[featured_image]',
                            'mime_in[featured_image,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                            'max_size[featured_image,5120]',
                        ],
                    ],
                ];

                if (!$this->validate($validationRule)) {
                    return redirect()->back()->with('error', $this->validator->getError('featured_image'))->withInput();
                }

                if (!$file->hasMoved()) {
                    $storedPath = upload_and_convert_webp($file, 'uploads/blogs');
                    if ($storedPath) {
                        $featured_image = $storedPath;
                    }
                }
            }
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'status' => $status,
            'category' => $category,
            'university_id' => ($category === 'university' && !empty($university_id)) ? $university_id : null,
            'featured_image' => $featured_image,
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
            'meta_keywords' => $this->request->getPost('meta_keywords'),
            'blog_category' => $this->request->getPost('blog_category'),
            'blog_tags' => $this->request->getPost('blog_tags')
        ];

        $blogModel->update($id, $data);
        return redirect()->to(base_url('admin/blogs'))->with('message', 'Blog updated.');
    }

    public function delete_blog($id)
    {
        // Block Deletion for everyone except Admin
        if (session()->get('role_id') != 1) {
            return redirect()->back()->with('error', 'Permission denied. You cannot delete items.');
        }

        $blogModel = new \App\Models\BlogModel();
        $blogModel->delete($id);
        return redirect()->to(base_url('admin/blogs'))->with('message', 'Blog deleted.');
    }

    /**
     * AJAX Endpoint to generate SEO tags using AI
     */
    public function generate_seo()
    {
        $content = $this->request->getJsonVar('content');
        if (!$content)
            return $this->response->setJSON(['error' => 'No content']);

        // Prioritize .env as requested by user
        $apiKey = env('openai_api_key_paid') ?: env('openai_api_key');

        // Fallback to DB if .env is empty
        if (empty($apiKey)) {
            $configToken = $this->db->table('site_config')->where('config_key', 'openai_api_key')->get()->getRowArray();
            if ($configToken) {
                $val = $configToken['config_value'];
                $decoded = json_decode($val, true);
                $apiKey = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
            }
        }
        $apiKey = trim($apiKey ?? '');

        if (empty($apiKey)) {
            return $this->response->setJSON(['error' => 'OpenRouter API Key is missing. Please configure it in Settings or .env file.']);
        }

        $configModel = $this->db->table('site_config')->where('config_key', 'ai_model')->get()->getRowArray();
        if ($configModel) {
            $val = $configModel['config_value'];
            $decoded = json_decode($val, true);
            $model = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }

        // Fallback to .env for model
        if (empty($model) || trim($model) === '') {
            $model = env('ai_model') ?: 'google/gemini-2.0-flash-001';
        }
        $model = trim($model, '"\' ');

        $prompt = "Analyze the following blog post content and generate a JSON response with 'meta_title', 'meta_description', 'keywords' (comma separated), 'blog_category' (a single best-fit category like 'Visa', 'Scholarships', 'Lifestyle', 'Admissions'), and 'blog_tags' (comma separated list of relevant topics). Content: " . substr(strip_tags($content), 0, 2000);

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are an SEO expert. Respond ONLY in JSON.'],
                ['role' => 'user', 'content' => $prompt]
            ]
        ];

        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
            "HTTP-Referer: " . base_url(),
            "X-Title: UniHunt_Admin"
        ]);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return $this->response->setJSON(['error' => 'Curl error: ' . curl_error($ch)]);
        }
        curl_close($ch);

        $response = json_decode($result, true);

        if (isset($response['error'])) {
            return $this->response->setJSON(['error' => 'OpenRouter Error: ' . ($response['error']['message'] ?? json_encode($response['error']))]);
        }

        $aiText = $response['choices'][0]['message']['content'] ?? '';

        if (empty($aiText)) {
            return $this->response->setJSON(['error' => 'AI returned empty response. Check your API key.']);
        }

        // Improved Extraction Logic
        $jsonString = $aiText;

        // 1. Try to extract from markdown code blocks (json or no label)
        if (preg_match('/```(?:json)?\s*(\{.*?\})\s*```/s', $aiText, $matches)) {
            $jsonString = $matches[1];
        } else {
            // 2. Try to find the first '{' and last '}' if no backticks
            $start = strpos($aiText, '{');
            $end = strrpos($aiText, '}');
            if ($start !== false && $end !== false) {
                $jsonString = substr($aiText, $start, ($end - $start) + 1);
            }
        }

        $finalJson = json_decode(trim($jsonString), true);

        if (!$finalJson) {
            // Log the failure for debugging
            log_message('error', '[AI SEO Error] Failed to parse: ' . $aiText);
            $finalJson = ['error' => 'AI failed to generate valid JSON structure. Please try again.'];
        }

        // Add new CSRF token to response
        $finalJson['csrf_token'] = csrf_hash();

        return $this->response->setJSON($finalJson);
    }

    // --- Comment Moderation ---

    public function comments()
    {
        $commentModel = new \App\Models\BlogCommentModel();
        $status = $this->request->getGet('status');

        $builder = $commentModel->select('blog_comments.*, users.name as user_name, blogs.title as blog_title')
            ->join('users', 'users.id = blog_comments.user_id', 'left')
            ->join('blogs', 'blogs.id = blog_comments.blog_id', 'left');

        if ($status && in_array($status, ['approved', 'pending', 'spam'])) {
            $builder->where('blog_comments.status', $status);
        }

        $comments = $builder->orderBy('blog_comments.created_at', 'DESC')
            ->paginate(15);

        return view('admin/comments/index', [
            'comments' => $comments,
            'pager' => $commentModel->pager,
            'currentStatus' => $status
        ]);
    }

    public function approve_comment($id)
    {
        $commentModel = new \App\Models\BlogCommentModel();
        $commentModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Comment approved.');
    }

    public function spam_comment($id)
    {
        $commentModel = new \App\Models\BlogCommentModel();
        $commentModel->update($id, ['status' => 'spam']);
        return redirect()->back()->with('success', 'Comment marked as spam.');
    }

    public function delete_comment($id)
    {
        $commentModel = new \App\Models\BlogCommentModel();
        $commentModel->delete($id);
        return redirect()->back()->with('success', 'Comment deleted.');
    }

    public function delete_user($id)
    {
        // Permission Check (Only Admin can delete users)
        if (session()->get('role_id') != 1) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        // Prevent self-deletion
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'You cannot delete your own account from here.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $db = Database::connect();
        $db->transStart();

        // Cleanup user-related data
        $db->table('bookmarks')->where('user_id', $id)->delete();
        $db->table('ai_requests')->where('user_id', $id)->delete();
        $db->table('ai_documents')->where('user_id', $id)->delete();
        $db->table('mock_interviews')->where('user_id', $id)->delete();

        $userModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Failed to delete user.');
        }

        return redirect()->back()->with('message', 'User and associated data deleted successfully.');
    }
}
