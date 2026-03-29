<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Helpers that will be automatically loaded on
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');

        // --- GLOBAL SESSION SYNC ---
        // Ensures that if a user's role is changed in the DB, it reflects immediately in the session.
        if (session()->get('isLoggedIn')) {
            $userId = session()->get('user_id');
            $db = \Config\Database::connect();
            $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

            if ($user) {
                // If role or university changed in DB, update session
                if (session()->get('role_id') != $user['role_id']) {
                    session()->set('role_id', $user['role_id']);
                }
                if (session()->get('university_id') != $user['university_id']) {
                    session()->set('university_id', $user['university_id']);
                }
                if (session()->get('user_name') != $user['name']) {
                    session()->set('user_name', $user['name']);
                }
            } else {
                // User no longer exists in DB, force logout
                session()->destroy();
                header('Location: ' . base_url('login'));
                exit;
            }
        }
    }

    protected function userExists($userId)
    {
        if (!$userId)
            return false;
        $db = \Config\Database::connect();
        return $db->table('users')->where('id', $userId)->countAllResults() > 0;
    }

    /**
     * Check permissions for current user
     * 
     * Roles:
     * 1: Admin - Full Access
     * 2: Student - No Access (Filtered by Admin Middleware usually)
     * 3: Counsellor - Create/Update, No Delete
     * 4: Uni Rep - Update Own Uni/Courses, No Delete, No Create Uni
     */
    protected function checkPermission(string $action, $resourceType = null, $resourceId = null)
    {
        $roleId = session()->get('role_id');
        $userUniId = session()->get('university_id');

        // Admin has full access
        if ($roleId == 1)
            return true;

        // Block Delete for non-admins
        if ($action === 'delete') {
            return false;
        }

        // Counsellor (3)
        if ($roleId == 3) {
            // Can do anything except delete 
            // (assuming Admin Middleware blocks students/others from reaching these controllers)
            return true;
        }

        // University Rep (4)
        if ($roleId == 4) {
            if ($resourceType === 'university') {
                // Can only update own university, cannot create new ones
                if ($action === 'create')
                    return false;
                if ($action === 'update' && $resourceId == $userUniId)
                    return true;
                return false;
            }

            if ($resourceType === 'course') {
                // Can create/update courses BUT only for their university
                // For 'create', we verify university_id in the post data in the controller
                if ($action === 'create')
                    return true;

                // For update, need to check if course belongs to their university
                if ($action === 'update' && $resourceId) {
                    $courseModel = new \App\Models\CourseModel();
                    $course = $courseModel->select('university_id')->find($resourceId);
                    return $course && $course['university_id'] == $userUniId;
                }
            }
        }

        return false;
    }

    /**
     * Centralized method to record AI tool usage.
     */
    protected function recordAiUsage(int $toolId, $input = null, $output = null)
    {
        $aiRequestModel = new \App\Models\AiRequestModel();
        $request = \Config\Services::request();

        // Extract payment info from input if present, else fallback to global Request
        $couponCode = (is_array($input) && isset($input['coupon_code'])) ? $input['coupon_code'] : $request->getPost('coupon_code');
        $razorpayOrderId = (is_array($input) && isset($input['razorpay_order_id'])) ? $input['razorpay_order_id'] : $request->getPost('razorpay_order_id');
        $razorpayPaymentId = (is_array($input) && isset($input['razorpay_payment_id'])) ? $input['razorpay_payment_id'] : $request->getPost('razorpay_payment_id');
        $finalAmount = (is_array($input) && isset($input['final_amount'])) ? $input['final_amount'] : 0;

        // Determine Status
        $paymentStatus = 'free';
        if ($razorpayPaymentId) {
            $paymentStatus = 'paid';
        } elseif ($couponCode) {
            // Note: In a real scenario, we'd check if coupon gave 100% discount
            // For now, if there's a coupon but no payment ID, assume it might be waived or pending
            $paymentStatus = 'waived';
        }

        $userId = session()->get('user_id');
        if (!$this->userExists($userId)) {
            $userId = null;
        }

        $data = [
            'user_id' => $userId,
            'tool_id' => $toolId,
            'input_data' => is_array($input) ? json_encode($input) : $input,
            'output_data' => is_array($output) ? json_encode($output) : $output,
            'payment_status' => $paymentStatus,
            'razorpay_order_id' => $razorpayOrderId,
            'razorpay_payment_id' => $razorpayPaymentId,
            'coupon_code' => $couponCode,
            'final_amount' => $finalAmount,
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $aiRequestModel->insert($data);
    }
}
