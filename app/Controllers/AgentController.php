<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\AdsModel;
use App\Models\UserModel;

class AgentController extends BaseController
{
    protected $agentId;
    protected $paymentService;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->paymentService = new \App\Libraries\PaymentService();

        // Access Control: Only Agents (5) and Admins (1) can access
        $roleId = session()->get('role_id');
        if (!session()->get('isLoggedIn') || !in_array($roleId, [1, 5])) {
            redirect()->to(base_url('dashboard'))->send();
            exit;
        }

        $this->agentId = session()->get('user_id');
        helper(['image']);
    }

    public function index()
    {
        $adModel = new AdsModel();
        $eventModel = new EventModel();

        $stats = [
            'total_ads' => $adModel->where('user_id', $this->agentId)->countAllResults(),
            'total_events' => $eventModel->where('user_id', $this->agentId)->countAllResults(),
            'ad_impressions' => $adModel->where('user_id', $this->agentId)->selectSum('impressions')->first()['impressions'] ?? 0,
            'ad_clicks' => $adModel->where('user_id', $this->agentId)->selectSum('clicks')->first()['clicks'] ?? 0,
        ];

        return view('agent/dashboard', [
            'title' => 'Agent Dashboard | UniHunt',
            'stats' => $stats
        ]);
    }

    // --- EVENTS ---
    public function events()
    {
        $model = new EventModel();
        $events = $model->where('user_id', $this->agentId)->orderBy('created_at', 'DESC')->paginate(10);

        return view('agent/events/index', [
            'title' => 'My Events | Agent',
            'events' => $events,
            'pager' => $model->pager
        ]);
    }

    public function create_event()
    {
        return view('agent/events/form', [
            'title' => 'Post New Event | Agent',
            'event' => null
        ]);
    }

    public function store_event()
    {
        $model = new EventModel();
        $data = $this->request->getPost();
        $data['user_id'] = $this->agentId;
        $data['status'] = 'draft'; // Agents' events start as draft/pending admin approval? 
        // User didn't specify approval, but usually it's needed. For now let's set 'active'.
        $data['status'] = 'active';

        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $storedPath = upload_and_convert_webp($file, 'uploads/events');
                if ($storedPath) {
                    $data['image'] = $storedPath;
                }
            }
        }

        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(base_url('agent/events'))->with('success', 'Event posted successfully.');
    }

    // --- ADS ---
    public function ads()
    {
        $model = new AdsModel();
        $ads = $model->where('user_id', $this->agentId)->orderBy('created_at', 'DESC')->paginate(10);

        return view('agent/ads/index', [
            'title' => 'My Ads | Agent',
            'ads' => $ads,
            'pager' => $model->pager
        ]);
    }

    public function create_ad()
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

        return view('agent/ads/form', [
            'title' => 'Create New Ad | Agent',
            'ad' => null,
            'settings' => $settings
        ]);
    }

    public function store_ad()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'format' => 'required|in_list[banner,native,rewarded,interstitial]',
            'placement' => 'required|max_length[50]',
            'total_days' => 'required|is_natural_no_zero|less_than_equal_to[365]',
            'link_url' => 'permit_empty|valid_url',
            'cta_text' => 'permit_empty|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new AdsModel();

        $data = [
            'tracking_id' => sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            ),
            'title' => $this->request->getPost('title'),
            'user_id' => $this->agentId,
            'source_type' => 'direct',
            'format' => $this->request->getPost('format'),
            'placement' => $this->request->getPost('placement'),
            'status' => 'pending_payment',
            'total_days' => (int) $this->request->getPost('total_days'),
        ];

        if ($file = $this->request->getFile('ad_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Ensure it's an image
                $validateImage = $this->validate([
                    'ad_image' => 'uploaded[ad_image]|is_image[ad_image]|ext_in[ad_image,jpg,jpeg,png,webp,gif]|max_size[ad_image,2048]'
                ]);

                if (!$validateImage) {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }

                $storedPath = upload_and_convert_webp($file, 'uploads/ads');
                if ($storedPath) {
                    $data['ad_content'] = json_encode([
                        'image_url' => $storedPath,
                        'link_url' => $this->request->getPost('link_url'),
                        'cta_text' => $this->request->getPost('cta_text')
                    ]);
                }
            }
        }

        $id = $model->insert($data);
        if (!$id) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        // Redirect to payment
        return redirect()->to(base_url('agent/ads/pay/' . $data['tracking_id']));
    }

    public function pay_ad($trackingId)
    {
        $model = new AdsModel();
        $ad = $model->where('user_id', $this->agentId)->where('tracking_id', $trackingId)->first();

        if (!$ad)
            return redirect()->to(base_url('agent/ads'));

        // Load pricing from site_config
        $db = \Config\Database::connect();
        $configRows = $db->table('site_config')->get()->getResultArray();
        $settings = [];
        foreach ($configRows as $c) {
            $settings[$c['config_key']] = trim($c['config_value'], '"\' ');
        }

        $perDayCost = (float) ($settings['ad_price_per_day'] ?? 199.00);
        $placementCosts = [
            'home_top' => (float) ($settings['ad_price_home_top'] ?? 120.00),
            'university_sidebar' => (float) ($settings['ad_price_university_sidebar'] ?? 150.00),
            'dashboard_main' => (float) ($settings['ad_price_dashboard_main'] ?? 99.00),
            'score_page' => (float) ($settings['ad_price_score_page'] ?? 199.00),
        ];

        $placementCost = $placementCosts[$ad['placement']] ?? 0;
        $totalDays = (int) $ad['total_days'];
        if ($totalDays <= 0)
            $totalDays = 30; // fallback

        $price = ($perDayCost * $totalDays) + $placementCost;

        // Create Razorpay Order Server-Side
        $order = $this->paymentService->createRazorpayOrder($price, 'ad_' . $ad['tracking_id']);
        if (isset($order['error'])) {
            return redirect()->to(base_url('agent/ads'))->with('error', 'Error generating payment order: ' . $order['error']);
        }

        return view('agent/ads/pay', [
            'title' => 'Pay for Ad | Agent',
            'ad' => $ad,
            'price' => $price,
            'razorpay_order_id' => $order['id'],
            'razorpay_key' => $this->paymentService->getRazorpayKey()
        ]);
    }

    public function verify_ad_payment()
    {
        $trackingId = $this->request->getPost('ad_id');
        $paymentId = $this->request->getPost('razorpay_payment_id');
        $orderId = $this->request->getPost('razorpay_order_id');
        $signature = $this->request->getPost('razorpay_signature');

        $model = new AdsModel();
        $ad = $model->where('tracking_id', $trackingId)->first();

        if (!$ad) {
            return $this->response->setJSON(['success' => false, 'error' => 'Ad not found']);
        }

        if (!$this->paymentService->verifySignature($orderId, $paymentId, $signature)) {
            return $this->response->setJSON(['success' => false, 'error' => 'Payment signature verification failed.']);
        }

        // Re-calculate price for DB record
        $db = \Config\Database::connect();
        $configRows = $db->table('site_config')->get()->getResultArray();
        $settings = [];
        foreach ($configRows as $c) {
            $settings[$c['config_key']] = trim($c['config_value'], '"\' ');
        }
        $perDayCost = (float) ($settings['ad_price_per_day'] ?? 199.00);
        $placementCosts = [
            'home_top' => (float) ($settings['ad_price_home_top'] ?? 120.00),
            'university_sidebar' => (float) ($settings['ad_price_university_sidebar'] ?? 150.00),
            'dashboard_main' => (float) ($settings['ad_price_dashboard_main'] ?? 99.00),
            'score_page' => (float) ($settings['ad_price_score_page'] ?? 199.00),
        ];

        $placementCost = $placementCosts[$ad['placement']] ?? 0;
        $totalDays = (int) $ad['total_days'];
        if ($totalDays <= 0)
            $totalDays = 30;

        $price = ($perDayCost * $totalDays) + $placementCost;

        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+$totalDays days"));

        $model->update($ad['id'], [
            'status' => 'active',
            'price_paid' => $price,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    public function reports()
    {
        $trackingId = $this->request->getGet('ad_id');
        $model = new AdsModel();

        $query = $model->where('user_id', $this->agentId);

        if ($trackingId) {
            $query = $query->where('tracking_id', $trackingId);
        }

        $ads = $query->findAll();

        return view('agent/reports', [
            'title' => 'Ad Performance Report | Agent',
            'ads' => $ads
        ]);
    }
}
