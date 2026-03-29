<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Load Currency Helper
        helper('currency');
        // Initialize User Currency (Detect & Cache)
        get_user_currency();

        $db = \Config\Database::connect();
        if (!$db->tableExists('roles')) {
            header('Location: ' . base_url('setup'));
            exit;
        }

        // Remember Me auto-login
        if (!session()->get('isLoggedIn') && isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];
            $sessionModel = new \App\Models\UserSessionModel();
            $userSession = $sessionModel->where('token', $token)
                ->where('expires_at >', date('Y-m-d H:i:s'))
                ->first();

            if ($userSession) {
                $userModel = new \App\Models\UserModel();
                $user = $userModel->find($userSession['user_id']);
                if ($user) {
                    $this->setUserSession($user);
                }
            }
        }

        // Onboarding Check: If logged in but name/phone missing, redirect to onboarding 
        if (session()->get('isLoggedIn') && !isAdmin()) {
            $currentPath = $request->getUri()->getPath();
            if ($currentPath !== 'onboarding' && $currentPath !== 'logout' && $currentPath !== 'auth/submit-onboarding') {
                $userModel = new \App\Models\UserModel();
                $user = $userModel->find(session()->get('user_id'));
                if (!$user['name'] || !$user['phone']) {
                    header('Location: ' . base_url('onboarding'));
                    exit;
                }
            }
        }
    }

    protected function getSiteSettings()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('site_config');
        $configs = $builder->get()->getResultArray();

        $settings = [];
        foreach ($configs as $c) {
            $val = $c['config_value'];
            $decoded = json_decode($val, true);
            $settings[$c['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }
        return $settings;
    }

    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'role_id' => $user['role_id'] ?? 2, // Default to student
            'university_id' => $user['university_id'] ?? null,
            'isLoggedIn' => true,
        ];
        session()->set($data);
    }

    public function index()
    {
        $countryModel = new \App\Models\CountryModel();
        $countries = $countryModel->select('countries.*, (SELECT COUNT(*) FROM universities WHERE universities.country_id = countries.id) as university_count')
            ->where('(SELECT COUNT(*) FROM universities WHERE universities.country_id = countries.id) >', 0)
            ->orderBy('university_count', 'DESC')
            ->limit(6)
            ->findAll();

        $universityModel = new \App\Models\UniversityModel();
        $topUniversities = $universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, states.name as state_name, (SELECT COUNT(*) FROM courses WHERE courses.university_id = universities.id) as course_count')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = universities.id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as gallery_image')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = universities.id AND (university_images.is_main = 1 OR university_images.image_type = "banner") ORDER BY (university_images.image_type = "gallery" AND university_images.is_main = 1) DESC, is_main DESC LIMIT 1) as image')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('states', 'states.id = universities.state_id', 'left')
            ->where('universities.ranking >', 0) // Ensure only ranked unis
            ->orderBy('universities.ranking', 'ASC')
            ->limit(4)
            ->findAll();

        // Trending Tags from Search History
        $searchHistoryModel = new \App\Models\SearchHistoryModel();
        $trendingTags = $searchHistoryModel->select('query, COUNT(*) as count')
            ->groupBy('query')
            ->orderBy('count', 'DESC')
            ->limit(4)
            ->findColumn('query');

        if (empty($trendingTags)) {
            $trendingTags = ['Computer Science', 'MBA', 'Data Science', 'Business Analytics'];
        }


        // Popular Courses (Top ranked universities' courses)
        $courseModel = new \App\Models\CourseModel();
        $popularCourses = $courseModel->select('courses.name, courses.duration_months, courses.level, universities.name as uni_name, countries.name as country_name, countries.slug as country_slug, universities.slug as uni_slug, universities.ranking')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id')
            ->where('universities.ranking >', 0)
            ->orderBy('universities.ranking', 'ASC')
            ->limit(4)
            ->find();


        // Recent Blogs
        $blogModel = new \App\Models\BlogModel();
        $recentBlogs = $blogModel->select('blogs.*')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as uni_gallery_image')
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();

        return view('web/index', [
            'title' => 'UniHunt | Discover Global Universities & Courses',
            'meta_desc' => 'UniHunt helps students find the best courses and universities worldwide with AI-powered tools and expert guidance.',
            'countries' => $countries,
            'topUniversities' => $topUniversities,
            'trendingTags' => $trendingTags,
            'stats' => [
                'students' => (new \App\Models\UserModel())->countAllResults(),
                'universities' => $universityModel->countAllResults(),
                'courses' => (new \App\Models\CourseModel())->countAllResults(),
                'countries' => $countryModel->countAllResults()
            ],
            'popularCourses' => $popularCourses,
            'recentBlogs' => $recentBlogs
        ]);
    }

    // --- UNIVERSITY SILO ---
    private function _get_search_filters()
    {
        $universityModel = new \App\Models\UniversityModel();
        $courseModel = new \App\Models\CourseModel();

        return [
            'filter_countries' => $universityModel->db->table('countries')->select('countries.name, countries.id')->join('universities', 'universities.country_id = countries.id')->groupBy('countries.id, countries.name')->orderBy('countries.name', 'ASC')->get()->getResultArray(),
            'filter_subjects' => $courseModel->distinct()->select('field')->where('field !=', '')->orderBy('field', 'ASC')->findColumn('field') ?? [],
            'filter_majors' => $courseModel->distinct()->select('name')->where('name !=', '')->orderBy('name', 'ASC')->limit(100)->findColumn('name') ?? [],
            'filter_levels' => $courseModel->distinct()->select('level')->where('level !=', '')->orderBy('level', 'ASC')->findColumn('level') ?? [],
            'filter_intakes' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'filter_max_tuition' => $courseModel->selectMax('tuition_fee')->first()['tuition_fee'] ?? 50000
        ];
    }

    public function university_index()
    {
        $universityModel = new \App\Models\UniversityModel();
        $params = $this->request->getGet();

        // 0. Pre-fill profile if logged in
        $userProfile = null;
        if (session()->get('isLoggedIn')) {
            $userProfile = (new \App\Models\UserAcademicProfileModel())->where('user_id', session()->get('user_id'))->first();
            // Pre-fill params from profile only if they are not explicitly in the request
            foreach (['academic_data', 'ielts', 'gre', 'backlogs', 'edu_15', 'stem'] as $f) {
                $db_field = $f === 'edu_15' ? 'is_15_years_education' : ($f === 'stem' ? 'stem_interest' : ($f === 'ielts' ? 'ielts_score' : ($f === 'gre' ? 'gre_score' : $f)));
                if (!isset($params[$f]) && isset($userProfile[$db_field])) {
                    $params[$f] = $userProfile[$db_field];
                }
            }
        }

        // --- PROFILE STORAGE ---
        if (session()->get('isLoggedIn') && $this->request->getGet('store_profile') === '1') {
            $profileModel = new \App\Models\UserAcademicProfileModel();
            $userId = session()->get('user_id');

            $profileData = [
                'user_id' => $userId,
                'academic_data' => $params['academic_data'] ?? null,
                'course_choice' => ($params['subject'] ?? '') . ($params['major'] ? ' / ' . $params['major'] : ''),
                'target_country' => !empty($params['country']) ? implode(', ', (array) $params['country']) : null,
                'ielts_score' => !empty($params['ielts']) ? $params['ielts'] : null,
                'gre_score' => !empty($params['gre']) ? $params['gre'] : null,
                'backlogs' => !empty($params['backlogs']) ? $params['backlogs'] : null,
                'is_15_years_education' => isset($params['edu_15']) ? 1 : 0,
                'stem_interest' => isset($params['stem']) ? 1 : 0,
            ];

            if ($userProfile) {
                $profileModel->update($userProfile['id'], $profileData);
            } else {
                $profileModel->insert($profileData);
            }
            $userProfile = array_merge((array) $userProfile, $profileData);
        }

        // --- AI RECOMMENDATIONS ---
        $aiNames = [];
        if (isset($params['ai_recommend']) && $params['ai_recommend'] === '1' && (!empty($params['academic_data']) || !empty($params['ielts']) || !empty($params['q']))) {
            $prompt = "You are an AI study abroad expert. Recommend matching universities (Max 5) for this student profile. Return ONLY as a JSON array of strings.
            Profile: Academic Score: " . ($params['academic_data'] ?? 'N/A') . ", IELTS: " . ($params['ielts'] ?? 'N/A') . ", GRE: " . ($params['gre'] ?? 'N/A') . ", Subject: " . ($params['subject'] ?? 'Any') . ", Country: " . (isset($params['country']) ? 'Selected' : 'Any');

            $aiResponse = $this->callAi($prompt);
            if ($aiResponse) {
                $aiNames = json_decode(trim($aiResponse, " \t\n\r\0\x0B`json"), true);
                if (!is_array($aiNames))
                    $aiNames = [];
            }
        }

        // Initialize query
        $query = $universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, 
            logo_img.file_name as logo_path, main_img.file_name as main_image_path')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = universities.id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as gallery_image')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left')
            ->join('university_images as main_img', 'main_img.id = (SELECT id FROM university_images WHERE university_images.university_id = universities.id AND (university_images.is_main = 1 OR university_images.image_type = "banner") ORDER BY (university_images.image_type = "gallery" AND university_images.is_main = 1) DESC, is_main DESC LIMIT 1)', 'left');

        if (!empty($params['q'])) {
            $q = $universityModel->db->escapeString($params['q']);
            $query->groupStart()->like('universities.name', $q)->orLike('countries.name', $q)->groupEnd();
        }

        if (!empty($params['country']))
            $query->whereIn('universities.country_id', (array) $params['country']);
        if (!empty($params['max_ranking']))
            $query->where('ranking <=', (int) $params['max_ranking']);
        if (!empty($params['max_tuition']))
            $query->where('tuition_fee_min <=', (int) $params['max_tuition']);
        if (!empty($params['subject'])) {
            $s = $universityModel->db->escapeString($params['subject']);
            $query->where("universities.id IN (SELECT university_id FROM courses WHERE field = '$s')");
        }
        if (!empty($params['major'])) {
            $m = $universityModel->db->escapeString($params['major']);
            $query->where("universities.id IN (SELECT university_id FROM courses WHERE name LIKE '%$m%')");
        }
        if (!empty($params['level'])) {
            $l = $universityModel->db->escapeString($params['level']);
            $query->where("universities.id IN (SELECT university_id FROM courses WHERE level = '$l')");
        }
        if (isset($params['stem']) && $params['stem'] === '1')
            $query->where("universities.id IN (SELECT university_id FROM courses WHERE stem = 1)");
        if (!empty($params['classification']))
            $query->where('classification', $params['classification']);
        if (isset($params['app_fee'])) {
            if ($params['app_fee'] === 'free')
                $query->where('application_fee', 0);
            elseif ($params['app_fee'] === 'paid')
                $query->where('application_fee >', 0);
        }

        if (!empty($aiNames)) {
            $escapedNames = array_map(function ($n) use ($universityModel) {
                return $universityModel->db->escape($n);
            }, $aiNames);
            $query->orderBy('FIELD(universities.name, ' . implode(',', $escapedNames) . ')', 'DESC');
        }

        $sort = $params['sort'] ?? 'ranking_asc';
        switch ($sort) {
            case 'tuition_asc':
                $query->orderBy('tuition_fee_min', 'ASC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            default:
                $query->orderBy('ranking', 'ASC');
                break;
        }

        $universities = $query->groupBy('universities.id, countries.name, countries.slug, logo_img.file_name, main_img.file_name')->paginate(18);
        $pager = $universityModel->pager;

        $viewData = array_merge([
            'title' => (!empty($params['q']) ? 'Search: ' . esc($params['q']) : 'Discover Universities') . ' | UniHunt',
            'meta_desc' => 'Search and compare best universities worldwide.',
            'universities' => $universities,
            'pager' => $pager,
            'ai_names' => $aiNames,
            'user_profile' => $userProfile,
            'query' => $params['q'] ?? '',
        ], $this->_get_search_filters());

        return view('web/search', $viewData);
    }

    public function university_by_country($country_slug)
    {
        $universityModel = new \App\Models\UniversityModel();

        // 0. Pre-fill profile if logged in
        $userProfile = null;
        if (session()->get('isLoggedIn')) {
            $userProfile = (new \App\Models\UserAcademicProfileModel())->where('user_id', session()->get('user_id'))->first();
        }

        $query = $universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug,
            logo_img.file_name as logo_path, main_img.file_name as main_image_path')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = universities.id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as gallery_image')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left')
            ->join('university_images as main_img', 'main_img.id = (SELECT id FROM university_images WHERE university_images.university_id = universities.id AND (university_images.is_main = 1 OR university_images.image_type = "banner") ORDER BY (university_images.image_type = "gallery" AND university_images.is_main = 1) DESC, is_main DESC LIMIT 1)', 'left')
            ->where('countries.slug', $country_slug);

        $universities = $query->groupBy('universities.id, countries.name, countries.slug, logo_img.file_name, main_img.file_name')->paginate(18);
        $pager = $universityModel->pager;

        // LOG DESTINATION INTEREST
        $interestModel = new \App\Models\DestinationInterestModel();
        $ip = $this->request->getIPAddress();

        // Throttling: only log once per hour for the same destination from the same IP
        $existing = $interestModel->where('ip_address', $ip)
            ->where('country_slug', $country_slug)
            ->where('created_at >', date('Y-m-d H:i:s', strtotime('-1 hour')))
            ->first();

        if (!$existing) {
            $interestModel->insert([
                'country_slug' => $country_slug,
                'ip_address' => $ip,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        $viewData = array_merge([
            'title' => 'Study in ' . ucfirst($country_slug) . ' | Universities & Guide | UniHunt',
            'meta_desc' => 'Find the best universities in ' . ucfirst($country_slug) . '. Get admission details, rankings, and visa info.',
            'country' => $country_slug,
            'universities' => $universities,
            'pager' => $pager,
            'user_profile' => $userProfile,
        ], $this->_get_search_filters());

        return view('web/search', $viewData);
    }

    public function university_details($country_slug, $uni_slug)
    {
        $universityModel = new \App\Models\UniversityModel();

        // Try finding by slug
        $university = $universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, countries.currency as country_currency, countries.living_cost_min, countries.living_cost_max, states.name as state_name')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('states', 'states.id = universities.state_id', 'left')
            ->where('universities.slug', $uni_slug)
            ->orWhere('universities.id', $uni_slug)
            ->first();

        if (!$university) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("University not found: " . $uni_slug);
        }

        // Fetch images
        $imageModel = new \App\Models\UniversityImageModel();
        $images = $imageModel->where('university_id', $university['id'])->findAll();

        $logo = null;
        $banner = null;
        $gallery = [];

        foreach ($images as $img) {
            if ($img['image_type'] === 'logo') {
                $logo = $img['file_name'];
            } elseif ($img['image_type'] === 'banner') {
                $banner = $img['file_name'];
            } else {
                $gallery[] = $img;
            }
        }

        // Fallbacks
        if (!$banner) {
            // Check for main image if banner not explicitly set
            foreach ($images as $img)
                if ($img['is_main']) {
                    $banner = $img['file_name'];
                    break;
                }
            if (!$banner && !empty($images))
                $banner = $images[0]['file_name'];
        }

        // Metadata
        $metadata = !empty($university['metadata']) ? json_decode($university['metadata'], true) : [];

        // Check if bookmarked
        $isBookmarked = false;
        if (session()->get('isLoggedIn')) {
            $bookmarkModel = new \App\Models\BookmarkModel();
            $isBookmarked = $bookmarkModel->where('user_id', session()->get('user_id'))
                ->where('entity_type', 'university')
                ->where('entity_id', $university['id'])
                ->first() ? true : false;
        }

        // Fetch dynamic requirement parameters
        $paramModel = new \App\Models\RequirementParameterModel();
        $requirementParams = $paramModel->whereIn('applies_to', ['University', 'Both'])
            ->groupStart()
            ->where('country_id', NULL)
            ->orWhere('country_id', $university['country_id'])
            ->groupEnd()
            ->findAll();

        // Fetch Approved Reviews
        $reviewModel = new \App\Models\ReviewModel();
        $reviews = $reviewModel->getApprovedReviewsByUniversity($university['id']);

        // Fetch Popular Courses
        $courseModel = new \App\Models\CourseModel();
        $courses = $courseModel->select('courses.*')
            ->where('university_id', $university['id'])
            ->limit(6)
            ->findAll();

        return view('web/university', [
            'title' => $university['name'] . ' | Admission & Courses | UniHunt',
            'meta_desc' => 'Explore ' . $university['name'] . ' in ' . $university['country_name'] . '. View tuition fees, rankings, and entry requirements.',
            'university' => $university,
            'images' => $images,
            'logo' => $logo,
            'banner' => $banner,
            'gallery' => $gallery,
            'metadata' => $metadata,
            'isBookmarked' => $isBookmarked,
            'requirementParams' => $requirementParams,
            'reviews' => $reviews,
            'courses' => $courses,
            'scholarshipBlogs' => (new \App\Models\BlogModel())->groupStart()->like('title', 'scholarship')->orLike('blog_category', 'scholarship')->orLike('blog_tags', 'scholarship')->groupEnd()->where('university_id', $university['id'])->where('status', 'published')->findAll(3),
            'latestUpdates' => (new \App\Models\BlogModel())->where('university_id', $university['id'])->where('status', 'published')->orderBy('created_at', 'DESC')->findAll(3),
            'og_image' => $banner ? base_url('uploads/universities/' . $banner) : ($logo ? base_url('uploads/universities/' . $logo) : base_url('favicon_io/favicon.ico')),
            'keywords' => $university['name'] . ', Study in ' . $university['country_name'] . ', ' . $university['name'] . ' admissions, ' . $university['name'] . ' courses'
        ]);
    }

    public function university_courses($country_slug, $uni_slug)
    {
        $universityModel = new \App\Models\UniversityModel();
        $university = $universityModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, countries.currency as country_currency')
            ->join('countries', 'countries.id = universities.country_id')
            ->where('universities.slug', $uni_slug)
            ->first();

        if (!$university) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $courseModel = new \App\Models\CourseModel();
        $courses = $courseModel->where('university_id', $university['id'])
            ->orderBy('level', 'ASC')
            ->findAll();

        return view('web/university_courses', [
            'title' => 'All Courses at ' . $university['name'] . ' | UniHunt',
            'meta_desc' => 'Browse all undergraduate and postgraduate programs offered by ' . $university['name'] . '.',
            'university' => $university,
            'courses' => $courses
        ]);
    }

    public function submit_review()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to write a review.');
        }

        $rules = [
            'university_id' => 'required',
            'rating' => 'required|integer|less_than_equal_to[5]',
            'comment' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please provide a valid rating and review (min 10 chars).');
        }

        $reviewModel = new \App\Models\ReviewModel();

        $data = [
            'university_id' => $this->request->getPost('university_id'),
            'user_id' => session()->get('user_id'),
            'reviewer_name' => $this->request->getPost('name') ?: (session()->get('user_name') ?: 'Verified Student'),
            'reviewer_designation' => $this->request->getPost('designation'),
            'rating' => $this->request->getPost('rating'),
            'comment' => $this->request->getPost('comment'),
            'status' => 'pending'
        ];

        if ($reviewModel->save($data)) {
            return redirect()->back()->with('success', 'Thank you! Your review has been submitted and is pending approval.');
        }

        return redirect()->back()->with('error', 'Failed to submit review.');
    }

    // --- COURSE SILO ---
    public function course_index()
    {
        return view('web/course', [
            'title' => 'Find Your Dream Course | UniHunt Course Finder',
            'meta_desc' => 'Search thousands of courses from top international universities. Filter by subject, level, and intake.'
        ]);
    }

    public function course_by_category($category_slug)
    {
        return view('web/course', [
            'title' => ucfirst($category_slug) . ' Courses Worldwide | UniHunt',
            'meta_desc' => 'Explore ' . $category_slug . ' programs from global universities. Compare tuition and requirements.',
            'category' => $category_slug
        ]);
    }

    public function course_details($segment1, $segment2, $segment3 = null)
    {
        // Handle variable routes:
        // Case A: /courses/country/uni/course_id (3 params) -> segment3 is ID
        // Case B: /courses/category/course_id (2 params) -> segment2 is ID

        $course_id = $segment3 ?? $segment2;

        // Optional: Could validate $segment1 (country) and $segment2 (uni) against the fetched course to ensure URL canonicalization
        // But for now, we just rely on the ID/Slug lookup.

        $courseModel = new \App\Models\CourseModel();
        $course = null;

        // Strategy: 
        // 1. If we have a university slug ($segment2), resolve the university first.
        // 2. Then fetch the university's courses and match the slug strictly using url_title()
        //    This avoids database schema changes for slugs and handles "lossy" limitations of str_replace.

        $uniId = null;
        if ($segment2 && !is_numeric($segment2)) {
            $uniModel = new \App\Models\UniversityModel();
            $uni = $uniModel->where('slug', $segment2)->first();
            if ($uni)
                $uniId = $uni['id'];
        }

        // Base Query
        $builder = $courseModel->select('courses.*, universities.name as university_name, universities.slug as university_slug, 
            universities.website as university_website, universities.ranking as university_ranking, universities.type as university_type,
            countries.name as country_name, countries.slug as country_slug, countries.currency as country_currency,
            states.name as state_name,
            logo_img.file_name as logo_path')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('states', 'states.id = universities.state_id', 'left')
            ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left');

        if ($uniId) {
            // Optimization: Fetch all courses for this university to do robust slug matching code-side
            // (Assumes sensible number of courses per university < 500)
            $universityCourses = $builder->where('courses.university_id', $uniId)->findAll();

            foreach ($universityCourses as $c) {
                // Check exact ID match (legacy) or Slug match
                // We generate the slug exactly how the View does: url_title(name, '-', true)
                if ($c['id'] == $course_id || url_title($c['name'], '-', true) === $course_id) {
                    $course = $c;
                    break;
                }
            }
        }

        // If not found by context (or context missing), try global fallback (only if ID-like or desperate)
        if (!$course) {
            // Reset builder is tricky, simpler to just re-instantiate if needed, but here we can try a direct ID fetch if numeric
            if (is_numeric($course_id)) {
                $course = $courseModel->select('courses.*, universities.name as university_name, universities.slug as university_slug, 
                            universities.website as university_website, universities.ranking as university_ranking, universities.type as university_type,
                            countries.name as country_name, countries.slug as country_slug, countries.currency as country_currency,
                            states.name as state_name,
                            logo_img.file_name as logo_path')
                    ->join('universities', 'universities.id = courses.university_id')
                    ->join('countries', 'countries.id = universities.country_id')
                    ->join('states', 'states.id = universities.state_id', 'left')
                    ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left')
                    ->where('courses.id', $course_id)
                    ->first();
            }
        }

        if (!$course) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Course not found");
        }

        // Decode metadata
        $courseMetadata = !empty($course['metadata']) ? json_decode($course['metadata'], true) : [];

        // Similarly for university metadata if needed
        $uniMetadata = !empty($course['uni_metadata']) ? json_decode($course['uni_metadata'], true) : [];

        // Similar Courses (same level or field in same university)
        $similarCourses = $courseModel->where('university_id', $course['university_id'])
            ->where('id !=', $course['id'])
            ->limit(3)
            ->findAll();

        // Fetch Requirement Parameters for display
        $reqModel = new \App\Models\RequirementParameterModel();
        $requirementParams = $reqModel->findAll();

        // Check for Bookmark
        $isBookmarked = false;
        if (session()->get('isLoggedIn')) {
            $bookmarkModel = new \App\Models\BookmarkModel();
            $exists = $bookmarkModel->where('user_id', session()->get('user_id'))
                ->where('entity_type', 'course')
                ->where('entity_id', $course['id'])
                ->first();
            if ($exists)
                $isBookmarked = true;
        }

        return view('web/course', [
            'title' => $course['name'] . ' at ' . $course['university_name'] . ' | UniHunt',
            'meta_desc' => 'Study ' . $course['name'] . ' at ' . $course['university_name'] . '. View tuition fees, eligibility, and syllabus.',
            'course' => $course,
            'metadata' => $courseMetadata,
            'similarCourses' => $similarCourses,
            'requirementParams' => $requirementParams,
            'isBookmarked' => $isBookmarked,
            'og_image' => !empty($course['logo_path']) ? base_url('uploads/universities/' . $course['logo_path']) : base_url('favicon_io/favicon.ico'),
            'keywords' => $course['name'] . ', ' . $course['university_name'] . ', Study ' . $course['name'] . ' in ' . $course['country_name']
        ]);
    }

    // --- AI TOOLS SILO ---
    public function ai_tools_hub()
    {
        return view('web/index', ['title' => 'AI Education Tools | UniHunt', 'anchor' => 'ai-tools']);
    }

    public function ai_sop()
    {
        return view('web/ai/sop-result', ['title' => 'AI SOP Generator | UniHunt']);
    }
    public function ai_sop_form()
    {
        return view('web/ai/sop-form', [
            'title' => 'AI SOP Generator | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_lor_form()
    {
        return view('web/ai/lor-form', [
            'title' => 'AI LOR Generator | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_visa_form()
    {
        return view('web/ai/visa-form', [
            'title' => 'AI Visa Document Checker | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_career_form()
    {
        return view('web/ai/career-form', [
            'title' => 'AI Career Outcome Predictor | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_resume_form()
    {
        return view('web/ai/resume-form', [
            'title' => 'AI Resume Builder | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_resume()
    {
        return view('web/ai/resume-result', ['title' => 'AI Resume Builder | UniHunt']);
    }
    public function ai_mock_interview()
    {
        return view('web/ai/mock-setup', [
            'title' => 'AI Mock Interview | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }
    public function ai_mock_result()
    {
        return view('web/ai/mock-result', ['title' => 'Mock Interview Results | UniHunt']);
    }
    public function ai_counsellor()
    {
        return view('web/ai/counsellor-form', [ // Reuse form as landing for now or make a landing
            'title' => 'AI University Counsellor | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }

    public function ai_counsellor_form()
    {
        return view('web/ai/counsellor-form', [
            'title' => 'AI University Counsellor | UniHunt',
            'settings' => $this->getSiteSettings()
        ]);
    }

    public function ai_form()
    {
        return view('web/ai/assessment-form', ['title' => 'Profile Assessment | UniHunt']);
    }

    // --- EVENTS SILO ---
    public function events()
    {
        $eventModel = new \App\Models\EventModel();

        $query = $eventModel->where('status', 'published')
            ->orderBy('start_date', 'ASC');

        // Search
        $search = $this->request->getVar('q');
        if (!empty($search)) {
            $query->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('event_type', $search)
                ->groupEnd();
        }

        // Filters
        $type = $this->request->getVar('type');
        if (!empty($type)) {
            $query->where('event_type', $type);
        }

        $locationType = $this->request->getVar('location_type');
        if (!empty($locationType)) {
            $query->where('location_type', $locationType);
        }

        $events = $query->paginate(9);

        // Get distinct event types for filter
        $types = $eventModel->distinct()->select('event_type')->where('status', 'published')->findColumn('event_type');

        return view('web/events', [
            'title' => 'Upcoming Education Events | UniHunt',
            'meta_desc' => 'Discover webinars, fairs, and workshops from top universities.',
            'events' => $events,
            'pager' => $eventModel->pager,
            'filter_types' => $types,
            'search' => $search
        ]);
    }

    public function event_details($slug)
    {
        $eventModel = new \App\Models\EventModel();

        $event = $eventModel->where('slug', $slug)->first();

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Event not found");
        }

        // Parse JSON fields
        $event['agenda'] = !empty($event['agenda']) ? json_decode($event['agenda'], true) : [];
        $event['speakers'] = !empty($event['speakers']) ? json_decode($event['speakers'], true) : [];
        $event['learning_points'] = !empty($event['learning_points']) ? json_decode($event['learning_points'], true) : [];

        // Formatting
        $event['start_date_formatted'] = date('F jS, Y', strtotime($event['start_date']));
        $event['start_time_formatted'] = date('g:i A', strtotime($event['start_time']));

        return view('web/event-details', [
            'title' => $event['title'] . ' | UniHunt Events',
            'meta_desc' => $event['short_description'],
            'event' => $event
        ]);
    }

    // --- BLOG SILO ---
    public function blog_index()
    {
        $blogModel = new \App\Models\BlogModel();

        // 0. Fetch Distinct Categories
        $categoryRows = $blogModel->where('status', 'published')
            ->where('blog_category !=', '')
            ->where('blog_category IS NOT NULL')
            ->select('blog_category')
            ->distinct()
            ->findAll();
        $categories = array_column($categoryRows, 'blog_category');

        // 1. Hero Post (Latest)
        // Search Logic
        $search = $this->request->getVar('q');
        $heroPost = null;

        if (empty($search)) {
            // Hero post only if not searching
            $heroPost = $blogModel->select('blogs.*, users.name as author_name')
                ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as uni_gallery_image')
                ->join('users', 'users.id = blogs.author_id', 'left')
                ->where('blogs.status', 'published')
                ->orderBy('blogs.created_at', 'DESC')
                ->first();
        }

        // 2. Regular Grid (Subsequent posts, excluding hero)
        $query = $blogModel->select('blogs.*, users.name as author_name')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" AND university_images.is_main = 0 LIMIT 1) as uni_gallery_image')
            ->join('users', 'users.id = blogs.author_id', 'left')
            ->where('blogs.status', 'published');

        if ($heroPost) {
            $query->where('blogs.id !=', $heroPost['id']);
        }

        // Apply search filters
        if (!empty($search)) {
            $query->groupStart()
                ->like('blogs.title', $search)
                ->orLike('blogs.content', $search)
                ->orLike('blogs.blog_tags', $search)
                ->orLike('blogs.blog_category', $search)
                ->groupEnd();
        }

        $blogs = $query->orderBy('blogs.created_at', 'DESC')->paginate(8);

        // 3. Trending Posts (Highest Views)
        $trendingPosts = $blogModel->select('blogs.*')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" LIMIT 1) as uni_gallery_image')
            ->where('status', 'published')
            ->orderBy('views', 'DESC')
            ->limit(4)
            ->findAll();

        return view('web/blog', [
            'title' => !empty($search) ? 'Search results for "' . esc($search) . '"' : 'Study Abroad Blog & Expert Advice | UniHunt',
            'meta_desc' => 'Latest news, guides, and tips for students planning to study abroad.',
            'heroPost' => $heroPost,
            'blogs' => $blogs,
            'trendingPosts' => $trendingPosts,
            'categories' => $categories,
            'pager' => $blogModel->pager,
            'category' => !empty($search) ? 'Search Results' : 'All',
            'search' => $search
        ]);
    }

    public function blog_category($categorySlug)
    {
        $blogModel = new \App\Models\BlogModel();

        // Fetch Categories for navigation and matching
        $categoryRows = $blogModel->where('status', 'published')
            ->where('blog_category !=', '')
            ->where('blog_category IS NOT NULL')
            ->select('blog_category')
            ->distinct()
            ->findAll();
        $categories = array_column($categoryRows, 'blog_category');

        // Match slug to actual category name
        $matchedCategory = '';
        foreach ($categories as $cat) {
            if (url_title($cat, '-', true) === $categorySlug) {
                $matchedCategory = $cat;
                break;
            }
        }

        // Fallback for cases where it's already a name or not found
        if (empty($matchedCategory)) {
            $matchedCategory = str_replace('-', ' ', $categorySlug);
        }

        $query = $blogModel->select('blogs.*, users.name as author_name')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" LIMIT 1) as uni_gallery_image')
            ->join('users', 'users.id = blogs.author_id', 'left')
            ->where('blogs.status', 'published')
            ->groupStart()
            ->where('category', $matchedCategory)
            ->orWhere('blog_category', $matchedCategory)
            ->groupEnd();

        // Search within Category
        $search = $this->request->getVar('q');
        if (!empty($search)) {
            $query->groupStart()
                ->like('blogs.title', $search)
                ->orLike('blogs.content', $search)
                ->orLike('blogs.blog_tags', $search)
                ->groupEnd();
        }

        $blogs = $query->orderBy('blogs.created_at', 'DESC')->paginate(9);

        // Trending for sidebar
        $trendingPosts = $blogModel->where('status', 'published')
            ->orderBy('views', 'DESC')
            ->limit(4)
            ->findAll();

        return view('web/blog', [
            'title' => esc($matchedCategory) . ' Guides | UniHunt Blog',
            'meta_desc' => 'Read our latest articles about ' . $matchedCategory . '.',
            'blogs' => $blogs,
            'trendingPosts' => $trendingPosts,
            'categories' => $categories,
            'pager' => $blogModel->pager,
            'category' => $matchedCategory, // Pass the original name for highlighting
            'search' => $search
        ]);
    }

    public function blog_tag($tagSlug)
    {
        $blogModel = new \App\Models\BlogModel();

        // Convert slug to readable (approximate) - "student-life" -> "student life"
        // Since tags in DB might be "Student Life" or "Data Science", simple replacement is a good start matching strategy
        $searchTag = str_replace('-', ' ', $tagSlug);

        // Fetch Categories for navigation
        $categoryRows = $blogModel->where('status', 'published')
            ->where('blog_category !=', '')
            ->where('blog_category IS NOT NULL')
            ->select('blog_category')
            ->distinct()
            ->findAll();
        $categories = array_column($categoryRows, 'blog_category');

        $query = $blogModel->select('blogs.*, users.name as author_name')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" LIMIT 1) as uni_gallery_image')
            ->join('users', 'users.id = blogs.author_id', 'left')
            ->where('blogs.status', 'published')
            ->like('blog_tags', $searchTag); // Loose matching for comma separated tags

        // Search within Tag
        $search = $this->request->getVar('q');
        if (!empty($search)) {
            $query->groupStart()
                ->like('blogs.title', $search)
                ->orLike('blogs.content', $search)
                ->orLike('blogs.blog_category', $search)
                ->groupEnd();
        }

        $blogs = $query->orderBy('blogs.created_at', 'DESC')->paginate(9);

        // Trending for sidebar
        $trendingPosts = $blogModel->where('status', 'published')
            ->orderBy('views', 'DESC')
            ->limit(4)
            ->findAll();

        return view('web/blog', [
            'title' => 'Posts tagged "' . esc(ucwords($searchTag)) . '" | UniHunt Blog',
            'meta_desc' => 'Articles tagged with ' . $searchTag . '.',
            'blogs' => $blogs,
            'trendingPosts' => $trendingPosts,
            'categories' => $categories,
            'pager' => $blogModel->pager,
            'category' => 'Tag: ' . ucwords($searchTag),
            'search' => $search
        ]);
    }

    public function blog_single($category, $slug)
    {
        $blogModel = new \App\Models\BlogModel();

        // Increment Views
        $blogModel->where('slug', $slug)->set('views', 'views+1', false)->update();

        $blog = $blogModel->select('blogs.*, users.name as author_name')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" LIMIT 1) as uni_gallery_image')
            ->join('users', 'users.id = blogs.author_id', 'left')
            ->where('slug', $slug)
            ->first();

        if (!$blog) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog post not found");
        }

        // Fetch Related Articles (same category, excluding current)
        $relatedBlogs = $blogModel->select('blogs.*, users.name as author_name')
            ->select('(SELECT file_name FROM university_images WHERE university_images.university_id = blogs.university_id AND university_images.image_type = "gallery" LIMIT 1) as uni_gallery_image')
            ->join('users', 'users.id = blogs.author_id', 'left')
            ->where('blogs.status', 'published')
            ->where('blogs.id !=', $blog['id'])
            ->groupStart()
            ->where('blogs.category', $blog['category'])
            ->orWhere('blogs.blog_category', $blog['blog_category'])
            ->groupEnd()
            ->orderBy('blogs.created_at', 'DESC')
            ->limit(3)
            ->findAll();

        // Fetch specific university if linked
        $university = null;
        if (!empty($blog['university_id'])) {
            $uniModel = new \App\Models\UniversityModel();
            $university = $uniModel->find($blog['university_id']);
        }

        // Fetch total subscribers for social proof
        $db = \Config\Database::connect();
        $totalSubscribers = $db->table('subscribers')->countAll();

        // Fetch Comments
        $commentModel = new \App\Models\BlogCommentModel();
        $comments = $commentModel->select('blog_comments.*, users.name as user_name, users.id as user_id')
            ->join('users', 'users.id = blog_comments.user_id', 'left')
            ->where('blog_id', $blog['id'])
            ->where('blog_comments.status', 'approved')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // Organize comments (simple parent-child)
        $threadedComments = [];
        $replies = [];
        foreach ($comments as $c) {
            if ($c['parent_id']) {
                $replies[$c['parent_id']][] = $c;
            } else {
                $threadedComments[] = $c;
            }
        }
        // Attach replies
        foreach ($threadedComments as &$c) {
            $c['replies'] = $replies[$c['id']] ?? [];
        }

        // --- SEO: Internal Linking Strategy ---
        // automatically link the University Name and Country Name in the blog content
        if ($university) {
            $keywords = [];

            // Ensure country details are available
            if (!isset($university['country_slug']) || !isset($university['country_name'])) {
                $countryModel = new \App\Models\CountryModel();
                $country = $countryModel->find($university['country_id']);
                if ($country) {
                    $university['country_slug'] = $country['slug'];
                    $university['country_name'] = $country['name'];
                }
            }

            // 1. Link University Name
            // Target: University Details Page
            if (isset($university['country_slug'])) {
                $uniUrl = base_url("universities/{$university['country_slug']}/{$university['slug']}");
                $keywords[$university['name']] = $uniUrl;
            }

            // 2. Link Country Name
            // Target: Country Study Page
            if (isset($university['country_slug']) && isset($university['country_name'])) {
                $countryUrl = base_url("study-in-{$university['country_slug']}");
                $keywords[$university['country_name']] = $countryUrl;
            }

            // Apply Linking
            $blog['content'] = $this->_auto_link_keywords($blog['content'], $keywords);
        }

        return view('web/blog-single', [
            'title' => $blog['title'] . ' | UniHunt Blog',
            'meta_desc' => substr(strip_tags($blog['content']), 0, 160),
            'blog' => $blog,
            'university' => $university,
            'relatedBlogs' => $relatedBlogs,
            'subscriberCount' => 45000 + $totalSubscribers,
            'comments' => $threadedComments,
            'commentCount' => count($comments),
            'og_image' => !empty($blog['featured_image']) ? base_url($blog['featured_image']) : base_url('favicon_io/favicon.ico'),
            'keywords' => $blog['title'] . ', Study Abroad Blog, UniHunt'
        ]);
    }

    public function blog_comment()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->back()->with('error', 'Please login to post a comment.');
        }

        $rules = [
            'blog_id' => 'required|integer',
            'comment' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Invalid comment data.');
        }

        $blogId = $this->request->getPost('blog_id');
        $comment = $this->request->getPost('comment');
        $parentId = $this->request->getPost('parent_id');

        $commentModel = new \App\Models\BlogCommentModel();
        $commentModel->insert([
            'blog_id' => $blogId,
            'user_id' => session()->get('user_id'),
            'parent_id' => !empty($parentId) ? $parentId : null,
            'comment' => strip_tags($comment),
            'status' => 'approved', // Auto-approve for now
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    public function subscribe()
    {
        $email = $this->request->getPost('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid email address']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('subscribers');

        // Check if already subscribed
        $existing = $builder->where('email', $email)->get()->getRow();
        if ($existing) {
            if ($this->request->hasHeader('HX-Request')) {
                return '<div class="bg-white/20 p-4 rounded-lg text-white font-bold text-center">You are already subscribed!</div>';
            }
            return $this->response->setJSON(['status' => 'success', 'message' => 'You are already subscribed!']);
        }

        $builder->insert([
            'email' => $email,
            'subscribed_at' => date('Y-m-d H:i:s')
        ]);

        if ($this->request->hasHeader('HX-Request')) {
            return '<div class="bg-secondary p-4 rounded-lg text-white font-bold text-center animate-bounce">Thank you for subscribing!</div>';
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Thank you for subscribing!']);
    }

    // --- OTHER ---
    public function about()
    {
        return view('web/about', ['title' => 'About UniHunt | Our Mission']);
    }
    public function contact()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]',
                'email' => 'required|valid_email',
                'subject' => 'required|min_length[3]',
                'message' => 'required|min_length[10]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $emailService = \Config\Services::email();

            $fromEmail = 'unihunt.overseas@gmail.com';
            $fromName = 'UniHunt Contact Form';

            // Try to use configured defaults if valid
            if (filter_var($emailService->fromEmail, FILTER_VALIDATE_EMAIL)) {
                $fromEmail = $emailService->fromEmail;
                $fromName = $emailService->fromName ?: $fromName;
            }

            $emailService->setFrom($fromEmail, $fromName);
            $emailService->setTo(env('email') ?: 'unihunt.overseas@gmail.com');
            $emailService->setReplyTo($this->request->getPost('email'), $this->request->getPost('name'));

            $subject = '[Contact Form] ' . $this->request->getPost('subject');
            $message = "Name: " . $this->request->getPost('name') . "\n";
            $message .= "Email: " . $this->request->getPost('email') . "\n";
            $message .= "Subject: " . $this->request->getPost('subject') . "\n\n";
            $message .= "Message:\n" . $this->request->getPost('message');

            $emailService->setSubject($subject);
            $emailService->setMessage($message);

            if ($emailService->send()) {
                return redirect()->back()->with('success', 'Thank you! Your message has been sent successfully.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to send email. Please try again later.');
                // In production, log $emailService->printDebugger(['headers']);
            }
        }
        return view('web/contact', ['title' => 'Contact Us | UniHunt Support']);
    }

    public function faq()
    {
        $faqs = [
            'account-support' => [
                'title' => 'Account Support',
                'items' => [
                    ['q' => 'How do I log in without a password?', 'a' => 'We use a secure OTP (One-Time Password) system. Simply enter your email address, and we will send you a code to log in instantly.'],
                    ['q' => 'Can I change my email address?', 'a' => 'Since your account is secured via Email OTP, you cannot change it directly. You must register a new account with the new email or contact support for assistance.'],
                    ['q' => 'How do I delete my account?', 'a' => 'Please contact support to request account deletion.']
                ]
            ],
            'application-tracking' => [
                'title' => 'Application Tracking',
                'items' => [
                    ['q' => 'How can I check my application status?', 'a' => 'Log in to your dashboard and view the "Applications" section for real-time updates.'],
                    ['q' => 'What does "Under Review" mean?', 'a' => 'It means the university admissions team is currently assessing your documents.'],
                    ['q' => 'Can I edit my application after submission?', 'a' => 'No, once submitted, applications cannot be edited. Contact support for critical errors.']
                ]
            ],
            'ai-tools-help' => [
                'title' => 'AI Tools Help',
                'items' => [
                    ['q' => 'Is the Resume Builder free?', 'a' => 'Yes, the basic resume builder is free for all registered users.'],
                    ['q' => 'How accurate is the Visa Chance Predictor?', 'a' => 'It uses historical data to provide an estimate, but the final decision lies with the visa officer.'],
                    ['q' => 'Can I save my Mock Invoice results?', 'a' => 'Yes, all mock interview sessions and feedback are saved in your dashboard history.']
                ]
            ],
            'scholarships' => [
                'title' => 'Scholarships',
                'items' => [
                    ['q' => 'How do I apply for scholarships?', 'a' => 'Browse the scholarships section and click "Apply Now" on eligible opportunities.'],
                    ['q' => 'Are scholarships available for all countries?', 'a' => 'We list scholarships for major study destinations including UK, USA, Canada, and Australia.'],
                    ['q' => 'When are scholarship deadlines?', 'a' => 'Deadlines vary by university and fund. Check individual listings for specific dates.']
                ]
            ]
        ];

        return view('web/faq', [
            'title' => 'Frequently Asked Questions | UniHunt',
            'faqs' => $faqs,
            'activeCategory' => $this->request->getGet('category') ?? 'account-support'
        ]);
    }
    public function cookies()
    {
        return view('web/cookies', ['title' => 'Cookie Policy | UniHunt']);
    }
    public function partnership()
    {
        return view('web/partnership', ['title' => 'Partner With Us | UniHunt']);
    }
    public function privacy()
    {
        return view('web/privacy', ['title' => 'Privacy Policy | UniHunt']);
    }

    public function terms()
    {
        return view('web/terms', ['title' => 'Terms and Conditions | UniHunt']);
    }
    public function refund_policy()
    {
        return view('web/refund_policy', ['title' => 'No Refund Policy | UniHunt']);
    }
    public function scholarship()
    {
        return view('web/scholarship', ['title' => 'Study Abroad Scholarships | UniHunt']);
    }
    public function search()
    {
        return $this->university_index();
    }


    public function login()
    {
        if (session()->get('isLoggedIn'))
            return redirect()->to(base_url('dashboard'));
        return view('web/login', ['title' => 'Sign In | UniHunt Account']);
    }

    public function otp()
    {
        if (session()->get('isLoggedIn'))
            return redirect()->to(base_url('dashboard'));
        return view('web/otp', ['title' => 'Verify OTP | UniHunt Security']);
    }

    public function user_ai()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userId = session()->get('user_id');

        // Fetch AI Documents (SOP, LOR, Resume)
        $docModel = new \App\Models\AiDocumentModel();
        $documents = $docModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        // Fetch Mock Visa Interviews
        $interviewModel = new \App\Models\MockInterviewModel();
        $interviews = $interviewModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        return view('user/ai', [
            'title' => 'AI Generation History | Dashboard',
            'documents' => $documents,
            'interviews' => $interviews
        ]);
    }

    public function user_dashboard()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userId = session()->get('user_id');

        // Redirect Admin, Counsellor, Uni Rep to Admin Panel, Agents to Agent Portal
        $roleId = session()->get('role_id');
        if (in_array($roleId, [1, 3, 4])) {
            return redirect()->to(base_url('admin'));
        }
        if ($roleId == 5) {
            return redirect()->to(base_url('agent'));
        }

        // Fetch AI Documents (SOP, LOR, Resume)
        $docModel = new \App\Models\AiDocumentModel();
        $documents = $docModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        // Fetch Mock Visa Interviews
        $interviewModel = new \App\Models\MockInterviewModel();
        $interviews = $interviewModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        // Fetch Standardized Mock Tests (IELTS, PTE, etc)
        $db = \Config\Database::connect();
        // Assuming mock_attempts table exists from previous context
        $mockTests = [];
        if ($db->tableExists('mock_attempts')) {
            $mockTests = $db->table('mock_attempts')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->get()->getResultArray();
        }

        // Fetch AI Search History (Visa Checker, Career)
        $historyModel = new \App\Models\AiSearchHistoryModel();
        $searches = $historyModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();

        // Fetch AI Tool Payments (Requests)
        $aiRequestModel = new \App\Models\AiRequestModel();
        $payments = $aiRequestModel->select('ai_requests.*, ai_tools.name as tool_name')
            ->join('ai_tools', 'ai_tools.id = ai_requests.tool_id')
            ->where('ai_requests.user_id', $userId)
            ->whereIn('ai_requests.payment_status', ['paid', 'waived', 'pending'])
            ->orderBy('ai_requests.created_at', 'DESC')
            ->findAll();

        // Fetch Bookmarks (Courses)
        $bookmarkModel = new \App\Models\BookmarkModel();
        $bookmarks = $bookmarkModel->select('bookmarks.*, courses.name as course_name, universities.name as university_name, universities.slug as uni_slug, countries.slug as country_slug')
            ->join('courses', 'courses.id = bookmarks.entity_id')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id')
            ->where('bookmarks.user_id', $userId)
            ->where('bookmarks.entity_type', 'course')
            ->orderBy('bookmarks.created_at', 'DESC')
            ->findAll();

        return view('user/dashboard', [
            'title' => 'User Dashboard | My Activities',
            'user' => session()->get(),
            'documents' => $documents,
            'interviews' => $interviews,
            'mockTests' => $mockTests,
            'searches' => $searches,
            'payments' => $payments,
            'bookmarks' => $bookmarks
        ]);
    }

    public function user_profile()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find(session()->get('user_id'));

        return view('user/profile', [
            'title' => 'My Profile | UniHunt',
            'user' => $user
        ]);
    }

    public function update_profile()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userId = session()->get('user_id');
        $userModel = new \App\Models\UserModel();

        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $marketing_consent = $this->request->getPost('marketing_consent') ? 1 : 0;

        if (empty($name) || empty($phone)) {
            return redirect()->back()->with('error', 'Name and Phone are required.');
        }

        $userModel->update($userId, [
            'name' => $name,
            'phone' => $phone,
            'marketing_consent' => $marketing_consent
        ]);

        // Update session name if changed
        session()->set('user_name', $name);

        return redirect()->to(base_url('profile'))->with('message', 'Profile updated successfully.');
    }

    public function request_role()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userId = session()->get('user_id');
        $requestedRoleId = $this->request->getPost('requested_role_id');

        if (empty($requestedRoleId)) {
            return redirect()->back()->with('error', 'Please select a role to request.');
        }

        // Validate role ID
        if (!in_array($requestedRoleId, [3, 4, 5])) {
            return redirect()->back()->with('error', 'Invalid role requested.');
        }

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if ($user['role_id'] != 2) {
            return redirect()->back()->with('error', 'Only students can request a role change.');
        }

        $roleRequestModel = new \App\Models\RoleRequestModel();

        // Check if there's already a pending request
        $existingRequest = $roleRequestModel->where('user_id', $userId)->where('status', 'pending')->first();
        if ($existingRequest) {
            return redirect()->back()->with('error', 'You already have a pending role request.');
        }

        $roleRequestModel->insert([
            'user_id' => $userId,
            'requested_role_id' => $requestedRoleId,
            'status' => 'pending'
        ]);

        // Send Email Notification to Admin
        $emailService = \Config\Services::email();
        $fromEmail = 'unihunt.overseas@gmail.com';
        // Best practice: get from settings if available
        $config = config('Email');
        if (!empty($config->fromEmail)) {
            $fromEmail = $config->fromEmail;
        }

        $emailService->setFrom($fromEmail, 'UniSearch Notification');
        $emailService->setTo('unihunt.overseas@gmail.com');

        $roleName = '';
        if ($requestedRoleId == 3)
            $roleName = 'Counselor';
        elseif ($requestedRoleId == 4)
            $roleName = 'University Representative';
        elseif ($requestedRoleId == 5)
            $roleName = 'Study Abroad Agent';

        $subject = 'New Role Request: ' . $roleName;
        $message = "A new role request has been submitted.\n\n";
        $message .= "User ID: " . $user['id'] . "\n";
        $message .= "Name: " . $user['name'] . "\n";
        $message .= "Email: " . $user['email'] . "\n";
        $message .= "Requested Role: " . $roleName . "\n\n";
        $message .= "Please log in to the admin dashboard to review this request.";

        $emailService->setSubject($subject);
        $emailService->setMessage($message);
        $emailService->send();

        return redirect()->to(base_url('profile'))->with('message', 'Your role request has been submitted successfully and is pending review.');
    }

    public function delete_profile()
    {
        if (!session()->get('isLoggedIn'))
            return redirect()->to(base_url('login'));

        $userId = session()->get('user_id');
        $userModel = new \App\Models\UserModel();

        // Delete User
        $userModel->delete($userId);

        // Destroy Session
        session()->destroy();

        return redirect()->to(base_url('/'))->with('message', 'Your account has been successfully deleted.');
    }

    private function getAiSettings()
    {
        $db = \Config\Database::connect();
        $query = $db->table('site_config')->whereIn('config_key', ['openai_api_key', 'ai_model', 'ai_temperature'])->get();
        $results = $query->getResultArray();
        $config = [];
        foreach ($results as $row) {
            $val = $row['config_value'];
            $decoded = json_decode($val, true);
            $config[$row['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }
        $apiKey = $config['openai_api_key'] ?? '';
        if (empty($apiKey))
            $apiKey = getenv('openai_api_key_paid') ?: getenv('openai_api_key');
        return [
            'apiKey' => trim($apiKey ?? "", '"\' '),
            'model' => $config['ai_model'] ?? 'google/gemini-2.0-flash-001',
            'temperature' => (float) ($config['ai_temperature'] ?? 0.7)
        ];
    }

    private function callAi($prompt)
    {
        $settings = $this->getAiSettings();
        if (empty($settings['apiKey']))
            return null;
        $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $settings['apiKey'], "Content-Type: application/json"]);
        $payload = ['model' => $settings['model'], 'messages' => [['role' => 'user', 'content' => $prompt]], 'temperature' => $settings['temperature']];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);
        return $result['choices'][0]['message']['content'] ?? "";
    }
    private function _auto_link_keywords($content, $keywords)
    {
        if (empty($keywords) || empty($content))
            return $content;

        // Sort keywords by length (descending) to avoid partial matches (e.g. replacing "University of X" before "University of X Y")
        uksort($keywords, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        foreach ($keywords as $keyword => $url) {
            if (empty($keyword) || empty($url))
                continue;

            // Pattern to match HTML tags OR the keyword
            // 1. (<[^>]+>) : Matches any HTML tag (ignored)
            // 2. (\b".preg_quote($keyword, '/')."\b) : Matches the keyword as a whole word
            $pattern = "/(<[^>]+>)|(\b" . preg_quote($keyword, '/') . "\b)/i";

            $limit = 1;
            $count = 0;

            // We use a closure to handle the replacement logic
            // only replace if group 2 (the keyword) is matched AND we haven't reached the limit
            $content = preg_replace_callback($pattern, function ($matches) use ($url, &$count, $limit) {
                // If it's a tag (Group 1), return it as is
                if (!empty($matches[1])) {
                    return $matches[1];
                }

                // If it's the keyword (Group 2), replace it if we haven't done so yet
                if (!empty($matches[2]) && $count < $limit) {
                    $count++;
                    return '<a href="' . $url . '" class="text-primary hover:underline font-semibold" title="' . esc($matches[2]) . '">' . $matches[2] . '</a>';
                }

                // Fallback (shouldn't be reached if regex is correct, but return match)
                return $matches[0];
            }, $content);
        }

        return $content;
    }
}
