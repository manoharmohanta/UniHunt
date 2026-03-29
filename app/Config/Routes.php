<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- MAIN PAGES ---
$routes->get('/', 'Home::index');
// Setup Wizard
$routes->group('setup', function ($routes) {
    $routes->get('/', 'Setup::index');
    $routes->get('database', 'Setup::database');
    $routes->post('database_save', 'Setup::databaseSave');
    $routes->get('admin', 'Setup::admin');
    $routes->post('admin_save', 'Setup::adminSave');
    $routes->get('success', 'Setup::success');
});
$routes->get('about', 'Home::about');
$routes->match(['get', 'post'], 'contact', 'Home::contact');
$routes->get('faq', 'Home::faq');
$routes->post('subscribe', 'Home::subscribe');
$routes->get('partnership', 'Home::partnership');
$routes->get('privacy', 'Home::privacy');
$routes->get('terms', 'Home::terms');
$routes->get('cookies', 'Home::cookies');
$routes->get('refund-policy', 'Home::refund_policy');
$routes->get('resume-builder', 'Home::ai_resume');
$routes->get('sop-generator', 'Home::ai_sop_form');
$routes->get('visa-checker', 'Home::ai_visa_form');
$routes->get('career-predictor', 'Home::ai_career_form');
$routes->get('university-counsellor', 'Home::ai_counsellor_form');
$routes->get('study-in-usa', 'Home::university_by_country/united-states');
$routes->get('study-in-uk', 'Home::university_by_country/united-kingdom');
$routes->get('study-in-canada', 'Home::university_by_country/canada');
$routes->get('study-in-australia', 'Home::university_by_country/australia');
$routes->get('study-in-germany', 'Home::university_by_country/germany');

// Comparison
$routes->post('comparison/toggle', 'ComparisonController::toggle');
$routes->get('compare-universities', 'ComparisonController::university');
$routes->get('compare-courses', 'ComparisonController::course');
$routes->get('comparison/clear', 'ComparisonController::clear');
$routes->get('search', 'Home::search');

// --- AUTH SILO ---
$routes->get('login', 'Home::login');
$routes->get('otp', 'Home::otp');
$routes->get('onboarding', 'Auth::onboarding');
$routes->post('auth/send-otp', 'Auth::sendOtp');
$routes->post('auth/verify-otp', 'Auth::verifyOtp');
$routes->post('auth/submit-onboarding', 'Auth::submitOnboarding');
$routes->get('logout', 'Auth::logout');

// --- UNIVERSITY SILO (Hierarchy: /universities -> /country -> /uni-slug) ---
$routes->group('universities', function ($routes) {
    $routes->get('/', 'Home::university_index'); // Main hub
    $routes->get('(:segment)', 'Home::university_by_country/$1'); // Country listing
    $routes->get('(:segment)/(:segment)', 'Home::university_details/$1/$2'); // Single University
    $routes->get('(:segment)/(:segment)/courses', 'Home::university_courses/$1/$2'); // University Courses List
    $routes->post('submit-review', 'Home::submit_review');
});

// --- COURSE SILO (Hierarchy: /courses -> /category -> /course-slug) ---
$routes->group('courses', function ($routes) {
    $routes->get('/', 'Home::course_index'); // Hub
    $routes->get('(:segment)', 'Home::course_by_category/$1'); // Category/Level listing
    $routes->get('(:segment)/(:segment)', 'Home::course_details/$1/$2'); // Backwards compatibility or 2-segment fallback
    $routes->get('(:segment)/(:segment)/(:any)', 'Home::course_details/$1/$2/$3'); // Country/Uni/Course
});

// --- EMAIL QUEUE PROCESSOR (FOR CRON) ---
$routes->get('admin/campaigns/process-queue', 'Admin\CampaignController::processQueue');

// --- AI TOOLS SILO ---
$routes->group('ai-tools', function ($routes) {
    $routes->get('/', 'AiController::index');
    $routes->get('sop-generator', 'Home::ai_sop');
    $routes->get('sop-generator-form', 'Home::ai_sop_form');
    $routes->post('generate-sop', 'AiController::generateSOP');
    $routes->get('lor-generator-form', 'Home::ai_lor_form');
    $routes->post('generate-lor', 'AiController::generateLOR');
    $routes->get('visa-checker-form', 'Home::ai_visa_form');
    $routes->post('visa-checker-result', 'AiController::visaCheckerResult');
    $routes->get('career-predictor-form', 'Home::ai_career_form');
    $routes->post('career-predictor-result', 'AiController::careerPredictorResult');
    $routes->get('resume-builder', 'Home::ai_resume');
    // AI Counsellor
    $routes->get('university-counsellor', 'Home::ai_counsellor');
    $routes->get('university-counsellor-form', 'Home::ai_counsellor_form');
    $routes->post('start-counsellor-session', 'AiController::startCounsellorSession');
    $routes->post('counsellor-chat', 'AiController::counsellorChat');
    $routes->get('counsellor-session/(:num)', 'AiController::viewCounsellorSession/$1');

    $routes->get('mock-interview', 'Home::ai_mock_interview');
    $routes->post('mock-session', 'AiController::startMockSession');
    $routes->post('mock-chat', 'AiController::mockChat');
    $routes->post('mock-finish', 'AiController::finishMockSession');
    $routes->get('mock-result', 'Home::ai_mock_result');
    $routes->get('form', 'Home::ai_form');
    $routes->get('resume-builder-form', 'Home::ai_resume_form');
    $routes->post('generate-resume', 'AiController::generateResume');
    $routes->post('suggest-summary', 'AiController::suggestSummary');
    $routes->post('suggest-highlights', 'AiController::suggestHighlights');

    // Mock Tests
    $routes->get('ielts', 'MockTestController::index/ielts');
    $routes->get('pte', 'MockTestController::index/pte');
    $routes->get('duolingo', 'MockTestController::index/duolingo');
    $routes->get('gre', 'MockTestController::index/gre');
    $routes->get('gmat', 'MockTestController::index/gmat');
    $routes->get('sat', 'MockTestController::index/sat');
    $routes->get('act', 'MockTestController::index/act');
    $routes->get('toefl', 'MockTestController::index/toefl');

    $routes->match(['get', 'post'], 'mock-take/(:segment)', 'MockTestController::start/$1');
    $routes->post('mock-submit', 'MockTestController::submit');
    $routes->get('mock-result/(:num)', 'MockTestController::result/$1');

    // History Viewers
    $routes->get('document/(:num)', 'AiController::viewDocument/$1');
    $routes->get('visa-checker-view/(:num)', 'AiController::viewVisaResult/$1');
    $routes->get('career-predictor-view/(:num)', 'AiController::viewCareerResult/$1');
    $routes->get('mock-interview-view/(:num)', 'AiController::viewMockInterview/$1');

    // Payments
    $routes->post('check-price', 'AiController::checkPrice');
    $routes->post('verify-payment', 'AiController::verifyPayment');
});

// --- BLOG SILO ---
$routes->group('blog', function ($routes) {
    $routes->get('events', 'Home::events');
    $routes->get('events/(:segment)', 'Home::event_details/$1');

    $routes->get('/', 'Home::blog_index');
    $routes->post('comment', 'Home::blog_comment');
    $routes->get('tag/(:segment)', 'Home::blog_tag/$1');
    $routes->addRedirect('tag', 'blog');
    $routes->addRedirect('category', 'blog');
    $routes->get('category/(:segment)', 'Home::blog_category/$1');
    $routes->get('(:segment)', 'Home::blog_category/$1');
    $routes->get('(:segment)/(:any)', 'Home::blog_single/$1/$2');
});

// --- EVENTS ---
$routes->get('events', 'Home::events');
$routes->get('events/(:any)', 'Home::event_details/$1');
$routes->get('scholarships', 'Home::scholarship');

// --- USER DASHBOARD ---
$routes->get('dashboard', 'Home::user_dashboard');
$routes->get('profile', 'Home::user_profile');
$routes->post('profile/update', 'Home::update_profile');
$routes->post('profile/request-role', 'Home::request_role');
$routes->post('profile/delete', 'Home::delete_profile');
$routes->get('ai-history', 'Home::user_ai');

// --- REST API ---
$routes->group('api', function ($routes) {
    $routes->post('auth/send-otp', 'Api\AuthController::sendOtp');
    $routes->post('auth/verify-otp', 'Api\AuthController::verifyOtp');
    $routes->get('home', 'Api\HomeController::index');
    $routes->get('universities', 'Api\UniversityController::index');
    $routes->get('universities/(:num)', 'Api\UniversityController::show/$1');
    $routes->get('courses/(:num)', 'Api\CourseController::show/$1');
    $routes->get('events', 'Api\EventController::index');
    $routes->get('events/(:num)', 'Api\EventController::show/$1');
    $routes->get('blogs/(:num)', 'Api\BlogController::show/$1');
    $routes->group('user', ['filter' => 'apiauth'], function ($routes) {
        $routes->get('profile', 'Api\UserController::profile');
        $routes->post('update-profile', 'Api\UserController::updateProfile');
        $routes->post('onboarding', 'Api\UserController::onboarding');
        $routes->post('delete', 'Api\UserController::deleteAccount');

        // Suggestions based on profile
        $routes->get('suggestions', 'Api\SuggestionController::suggestByProfile');
        $routes->get('university-match', 'Api\SuggestionController::matchByProfile');
        $routes->get('course-match', 'Api\SuggestionController::matchCoursesByProfile');
        $routes->get('scholarship-match', 'Api\SuggestionController::matchScholarshipsByProfile');
        $routes->get('career-prediction', 'Api\SuggestionController::predictCareer');

        // Bookmarks
        $routes->get('bookmarks', 'Api\BookmarkController::index');
        $routes->post('bookmarks/toggle', 'Api\BookmarkController::toggle');
    });

    // AI Tools API
    $routes->group('ai', function ($routes) {
        $routes->get('tools', 'Api\AiController::getTools');

        $routes->group('', ['filter' => 'apiauth'], function ($routes) {
            // Protection needed but currently simplifying logic
            $routes->post('check-price', 'Api\AiController::checkPrice');
            $routes->post('verify-payment', 'Api\AiController::verifyPayment');
            $routes->post('generate-sop', 'Api\AiController::generateSop');
            $routes->post('generate-visa', 'Api\AiController::generateVisa');
            $routes->post('generate-resume', 'Api\AiController::generateResume');
            $routes->post('generate-counsellor', 'Api\AiController::generateCounsellor');
            $routes->post('generate-lor', 'Api\AiController::generateLor');
            $routes->post('generate-mock-interview', 'Api\AiController::generateMockInterview');
            $routes->post('mock-chat', 'Api\AiController::mockChat');
            $routes->post('mock-finish', 'Api\AiController::mockFinish');
            $routes->get('orders', 'Api\AiController::getOrders');
            $routes->get('orders/(:num)', 'Api\AiController::getOrderDetails/$1');
        });
    });

    // Suggestion API
    $routes->get('suggest', 'Api\SuggestionController::suggest');

    // Ads API
    $routes->get('ads/fetch', 'Api\AdController::fetch');
    $routes->post('ads/track-impression/(:num)', 'Api\AdController::track_impression/$1');
    $routes->post('ads/track-click/(:num)', 'Api\AdController::track_click/$1');

});

// --- AGENT DASHBOARD ---
$routes->group('agent', ['filter' => 'agent'], function ($routes) {
    $routes->get('/', 'AgentController::index');
    $routes->get('dashboard', 'AgentController::index');

    // Events
    $routes->get('events', 'AgentController::events');
    $routes->get('events/create', 'AgentController::create_event');
    $routes->post('events/store', 'AgentController::store_event');

    // Ads
    $routes->get('ads', 'AgentController::ads');
    $routes->get('ads/create', 'AgentController::create_ad');
    $routes->post('ads/store', 'AgentController::store_ad');
    $routes->get('ads/pay/(:any)', 'AgentController::pay_ad/$1');
    $routes->post('ads/verify-payment', 'AgentController::verify_ad_payment');

    // Reports
    $routes->get('reports', 'AgentController::reports');
});

// --- SEO SITEMAP ---
$routes->get('sitemap.xml', 'SitemapController::index');
$routes->get('sitemap-pages.xml', 'SitemapController::pages');
$routes->get('sitemap-universities.xml', 'SitemapController::universities');
$routes->get('sitemap-courses.xml', 'SitemapController::courses');
$routes->get('sitemap-blogs.xml', 'SitemapController::blogs');

// Bookmarks (Global)
$routes->post('bookmark/toggle', 'BookmarkController::toggle');

// --- ADMIN DASHBOARD ---
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->get('users', 'AdminController::users');
    $routes->post('users/update-status', 'AdminController::update_user_status');
    $routes->post('users/update-role', 'AdminController::update_user_role');
    $routes->get('settings', 'AdminController::settings');
    $routes->post('settings/save', 'AdminController::save_settings');
    $routes->post('settings/generate-ai', 'AdminController::generate_settings_ai');

    // Blog
    $routes->get('blogs', 'AdminController::blogs');
    $routes->get('blogs/create', 'AdminController::create_blog');
    $routes->post('blogs/store', 'AdminController::store_blog');
    $routes->get('blogs/edit/(:num)', 'AdminController::edit_blog/$1');
    $routes->post('blogs/update/(:num)', 'AdminController::update_blog/$1');
    $routes->get('blogs/delete/(:num)', 'AdminController::delete_blog/$1');
    $routes->post('generate-seo', 'AdminController::generate_seo');

    // Blog Comments
    $routes->get('comments', 'AdminController::comments');
    $routes->get('comments/approve/(:num)', 'AdminController::approve_comment/$1');
    $routes->get('comments/spam/(:num)', 'AdminController::spam_comment/$1');
    $routes->get('comments/delete/(:num)', 'AdminController::delete_comment/$1');

    // Locations (Countries, States, Cities)
    $routes->get('locations', 'Admin\LocationController::index');
    $routes->get('locations/get-states/(:num)', 'Admin\LocationController::getStatesByCountry/$1');
    $routes->post('locations/store-country', 'Admin\LocationController::storeCountry');
    $routes->post('locations/update-country/(:num)', 'Admin\LocationController::updateCountry/$1');
    $routes->get('locations/delete-country/(:num)', 'Admin\LocationController::deleteCountry/$1');

    $routes->post('locations/store-state', 'Admin\LocationController::storeState');
    $routes->post('locations/update-state/(:num)', 'Admin\LocationController::updateState/$1');
    $routes->get('locations/delete-state/(:num)', 'Admin\LocationController::deleteState/$1');

    $routes->post('locations/store-city', 'Admin\LocationController::storeCity');
    $routes->post('locations/update-city/(:num)', 'Admin\LocationController::updateCity/$1');
    $routes->get('locations/delete-city/(:num)', 'Admin\LocationController::deleteCity/$1');

    // Universities
    $routes->get('universities/modify-listing/(:num)', 'Admin\UniversityController::editUniversity/$1');
    $routes->get('universities', 'Admin\UniversityController::index');
    $routes->get('universities/create', 'Admin\UniversityController::create');
    $routes->post('universities/store', 'Admin\UniversityController::store');
    $routes->post('universities/update/(:num)', 'Admin\UniversityController::update/$1');
    $routes->post('universities/upload-bulk', 'Admin\UniversityController::uploadBulk');
    $routes->post('universities/generate-details', 'Admin\UniversityController::generateDetails');
    $routes->post('universities/delete-image/(:num)', 'Admin\UniversityController::deleteImage/$1');
    $routes->post('universities/scrape-images', 'Admin\UniversityController::scrapeImages');
    $routes->get('universities/delete/(:num)', 'Admin\UniversityController::delete/$1');


    // Courses
    $routes->get('courses', 'Admin\CourseController::index');
    $routes->get('courses/create', 'Admin\CourseController::create');
    $routes->get('courses/edit/(:num)', 'Admin\CourseController::edit/$1');
    $routes->get('courses/edit/(:num)', 'Admin\CourseController::edit/$1');
    $routes->post('courses/update/(:num)', 'Admin\CourseController::update/$1');
    $routes->get('courses/delete/(:num)', 'Admin\CourseController::delete/$1');
    $routes->post('courses/store', 'Admin\CourseController::store');
    $routes->get('courses/download-template', 'Admin\CourseController::downloadTemplate');
    $routes->post('courses/upload-bulk', 'Admin\CourseController::uploadBulk');
    $routes->post('courses/ai-autofill', 'Admin\CourseController::aiAutoFill');
    $routes->post('courses/ai-generate-insights', 'Admin\CourseController::generateInsights');

    // Users & Roles
    $routes->get('users/delete/(:num)', 'AdminController::delete_user/$1');

    $routes->get('role-requests', 'AdminController::role_requests');
    $routes->post('role-requests/approve/(:num)', 'AdminController::approve_role_request/$1');
    $routes->post('role-requests/reject/(:num)', 'AdminController::reject_role_request/$1');

    // Requirements & Global Settings
    $routes->get('requirements', 'Admin\RequirementController::index');
    $routes->post('requirements/store-param', 'Admin\RequirementController::storeParam');
    $routes->post('requirements/update-param', 'Admin\RequirementController::updateParam');
    $routes->get('requirements/delete-param/(:num)', 'Admin\RequirementController::deleteParam/$1');
    $routes->post('requirements/get-requirements', 'Admin\RequirementController::getRequirements');

    // Exchange Rates
    $routes->get('exchange-rates', 'Admin\SettingsController::exchangeRates');
    $routes->post('exchange-rates/store', 'Admin\SettingsController::storeExchangeRate');
    $routes->get('exchange-rates/delete/(:any)', 'Admin\SettingsController::deleteExchangeRate/$1');

    // Visa Types
    $routes->get('visa-types', 'Admin\SettingsController::visaTypes');
    $routes->post('visa-types/store', 'Admin\SettingsController::storeVisaType');
    $routes->get('visa-types/delete/(:num)', 'Admin\SettingsController::deleteVisaType/$1');



    // Ads Management
    $routes->get('ads', 'Admin\Ads::index');
    $routes->get('ads/create', 'Admin\Ads::create');
    $routes->post('ads/store', 'Admin\Ads::store');
    $routes->get('ads/edit/(:num)', 'Admin\Ads::edit/$1');
    $routes->post('ads/update/(:num)', 'Admin\Ads::update/$1');
    $routes->get('ads/delete/(:num)', 'Admin\Ads::delete/$1');
    $routes->get('ads/toggle-pause/(:num)', 'Admin\Ads::togglePause/$1');

    // Coupons
    $routes->get('coupons', 'Admin\CouponController::index');
    $routes->get('coupons/new', 'Admin\CouponController::new');
    $routes->post('coupons/create', 'Admin\CouponController::create');
    $routes->get('coupons/delete/(:num)', 'Admin\CouponController::delete/$1');

    // AI Tool Payments
    $routes->get('payments', 'AdminController::payments');

    // Student Reviews
    $routes->get('reviews', 'Admin\Reviews::index');
    $routes->post('reviews/update-status', 'Admin\Reviews::update_status');
    $routes->get('reviews/delete/(:num)', 'Admin\Reviews::delete/$1');

    // Events
    $routes->get('events', 'Admin\EventController::index');
    $routes->get('events/new', 'Admin\EventController::new');
    $routes->post('events/create', 'Admin\EventController::create');
    $routes->get('events/edit/(:num)', 'Admin\EventController::edit/$1');
    $routes->post('events/update/(:num)', 'Admin\EventController::update/$1');
    $routes->get('events/delete/(:num)', 'Admin\EventController::delete/$1');

    // Email Campaigns
    $routes->get('campaigns', 'Admin\CampaignController::index');
    $routes->get('campaigns/new', 'Admin\CampaignController::new');
    // Wizard Steps
    $routes->get('campaigns/step1', 'Admin\CampaignController::step1');
    $routes->post('campaigns/step1', 'Admin\CampaignController::processStep1');
    $routes->get('campaigns/step2', 'Admin\CampaignController::step2');
    $routes->post('campaigns/step2', 'Admin\CampaignController::processStep2');
    $routes->get('campaigns/step3', 'Admin\CampaignController::step3');
    $routes->post('campaigns/confirm', 'Admin\CampaignController::confirm');
    // Test Prep Module
    $routes->get('test-prep', 'Admin\TestPrep\TestPrepController::index');
    $routes->get('test-prep/modules/(:num)', 'Admin\TestPrep\TestPrepController::modules/$1');

    // Resource Management
    $routes->get('test-prep/resources/(:num)', 'Admin\TestPrep\TestPrepController::resources/$1');
    $routes->post('test-prep/store-resource', 'Admin\TestPrep\TestPrepController::storeResource');
    $routes->get('test-prep/manage-resource/(:num)', 'Admin\TestPrep\TestPrepController::manageResource/$1');
    $routes->get('test-prep/delete-resource/(:num)', 'Admin\TestPrep\TestPrepController::deleteResource/$1');

    $routes->get('test-prep/create-question/(:num)', 'Admin\TestPrep\TestPrepController::createQuestion/$1');
    $routes->post('test-prep/store-question', 'Admin\TestPrep\TestPrepController::storeQuestion');
    $routes->get('test-prep/delete-question/(:num)', 'Admin\TestPrep\TestPrepController::deleteQuestion/$1');
    $routes->post('test-prep/ai-suggest-topic', 'Admin\TestPrep\TestPrepController::aiSuggestTopic');

    // Database Management
    $routes->get('database', 'Admin\DatabaseController::index');
    $routes->post('database/switch', 'Admin\DatabaseController::switch');
    $routes->post('database/migrate', 'Admin\DatabaseController::migrate');

});

