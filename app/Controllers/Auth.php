<?php

namespace App\Controllers;

use App\Models\OtpModel;
use App\Models\UserModel;
use App\Models\UserSessionModel;
use CodeIgniter\Controller;
use Config\Services;

class Auth extends BaseController
{
    protected $otpModel;
    protected $userModel;
    protected $sessionModel;

    public function __construct()
    {
        $this->otpModel = new OtpModel();
        $this->userModel = new UserModel();
        $this->sessionModel = new UserSessionModel();
    }

    /**
     * Send OTP for unified Login/Register
     */
    public function sendOtp()
    {
        $email = $this->request->getPost('email') ?: $this->request->getPost('login');
        $isResend = $this->request->getPost('resend') === 'true';

        // If email is missing, check session (for resend requests)
        if (empty($email)) {
            $authData = session()->get('auth_data');
            $email = $authData['email'] ?? null;
        }

        if (empty($email)) {
            return $this->errorResponse('Email is required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->errorResponse('Please enter a valid email address.');
        }

        // Generate 6-digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Save OTP
        $this->otpModel->insert([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expires_at
        ]);

        // Send Email
        $this->sendEmailOtp($email, $otp);

        // Store email in session to use after verification
        session()->set('auth_data', [
            'email' => $email,
            'redirect' => $this->request->getPost('redirect'),
            'bookmark_entity' => $this->request->getPost('bookmark_entity'),
            'bookmark_id' => $this->request->getPost('bookmark_id')
        ]);

        if ($this->request->isAJAX() || $this->request->hasHeader('HX-Request')) {
            if ($isResend) {
                return '<div class="p-3 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-100 dark:border-green-900 shadow-sm" role="alert">
                          <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">check_circle</span>
                            <span>A new verification code has been sent to <strong>' . $email . '</strong></span>
                          </div>
                        </div>';
            }
            return $this->response->setHeader('HX-Redirect', base_url('otp'));
        }

        return redirect()->to(base_url('otp'));
    }

    /**
     * Verify OTP and Login/Create User
     */
    public function verifyOtp()
    {
        $otpCode = $this->request->getPost('otp');
        $authData = session()->get('auth_data');

        if (!$authData || !$otpCode) {
            return $this->errorResponse('Invalid request session.');
        }

        $email = $authData['email'];

        // Check OTP in DB
        $dbOtp = $this->otpModel->where('email', $email)
            ->where('otp', $otpCode)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();

        if (!$dbOtp) {
            return $this->errorResponse('Invalid or expired OTP code.');
        }

        // Check if user exists
        $user = $this->userModel->where('email', $email)->first();

        if ($user && ($user['status'] === 'blocked' || $user['status'] === 'deleted')) {
            return $this->errorResponse('Your account has been ' . $user['status'] . '. Please contact support.');
        }

        if (!$user) {
            // Create user placeholder
            $userId = $this->userModel->insert([
                'email' => $email,
                'role_id' => 2, // Default to Student
                'registered_from' => 'web',
                'is_verified' => true,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $user = $this->userModel->find($userId);
        }

        // Set Session
        $this->setUserSession($user);

        // Set Remember Me (30 days)
        $this->setRememberMe($user['id']);

        $targetUrl = (empty($user['name']) || empty($user['phone'])) ? base_url('onboarding') : base_url('dashboard');

        // Handle post-login redirection and automatic bookmarking
        if (!empty($authData['redirect'])) {
            $targetUrl = $authData['redirect'];

            // If it's a bookmark flow, handle it here
            if (!empty($authData['bookmark_entity']) && !empty($authData['bookmark_id'])) {
                $bookmarkModel = new \App\Models\BookmarkModel();
                $exists = $bookmarkModel->where('user_id', $user['id'])
                    ->where('entity_type', $authData['bookmark_entity'])
                    ->where('entity_id', $authData['bookmark_id'])
                    ->first();
                if (!$exists) {
                    $bookmarkModel->insert([
                        'user_id' => $user['id'],
                        'entity_type' => $authData['bookmark_entity'],
                        'entity_id' => $authData['bookmark_id'],
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }

        if ($this->request->isAJAX() || $this->request->hasHeader('HX-Request')) {
            return $this->response->setHeader('HX-Redirect', $targetUrl);
        }

        return redirect()->to($targetUrl);
    }

    /**
     * Show Onboarding Page
     */
    public function onboarding()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $user = $this->userModel->find(session()->get('user_id'));
        if ($user['name'] && $user['phone']) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('web/onboarding');
    }

    /**
     * Submit Onboarding Details
     */
    public function submitOnboarding()
    {
        if (!session()->get('isLoggedIn')) {
            if ($this->request->isAJAX() || $this->request->hasHeader('HX-Request'))
                return $this->response->setHeader('HX-Redirect', base_url('login'));
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');

        $consent = $this->request->getPost('marketing_consent');

        if (empty($name) || empty($phone) || empty($consent)) {
            return $this->errorResponse('All fields including marketing consent are required.');
        }

        if (!preg_match('/^[0-9]{10,15}$/', $phone)) {
            return $this->errorResponse('Please enter a valid numeric phone number (10-15 digits).');
        }

        if (strlen($name) < 3 || strlen($name) > 25) {
            return $this->errorResponse('Name must be between 3 and 25 characters.');
        }

        $roleId = $this->request->getPost('role_id') ?: 2;
        
        try {
            $this->userModel->update($userId, [
                'name' => $name,
                'phone' => $phone,
                'role_id' => $roleId,
                'marketing_consent' => $consent
            ]);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return $this->errorResponse('The phone number is already in use. Please use a different number.');
            }
            return $this->errorResponse('An unexpected error occurred. Please try again.');
        }
       
        session()->set('user_name', $name);
        session()->set('role_id', $roleId);

        if ($this->request->isAJAX() || $this->request->hasHeader('HX-Request')) {
            return $this->response->setHeader('HX-Redirect', base_url('dashboard'));
        }

        return redirect()->to(base_url('dashboard'));
    }

    private function errorResponse($message)
    {
        if ($this->request->isAJAX() || $this->request->hasHeader('HX-Request')) {
            return '<div class="p-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-100 dark:border-red-900 shadow-sm transition-all animate-pulse" role="alert">
                      <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">error</span>
                        <span class="font-bold">Error:</span> ' . $message . '
                      </div>
                    </div>';
        }
        return redirect()->back()->with('error', $message);
    }

    /**
     * Set User Session
     */
    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'role_id' => $user['role_id'],
            'user_name' => $user['name'] ?? null,
            'user_email' => $user['email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
    }

    /**
     * Set Remember Me Cookie
     */
    private function setRememberMe($userId)
    {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

        $this->sessionModel->insert([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiry,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Set cookie
        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/');
    }

    /**
     * Email sending helper
     */
    private function sendEmailOtp($to, $otp)
    {
        $email = Services::email();
        $email->setTo($to);
        $email->setSubject('Your UniHunt Verification Code');

        $message = view('emails/otp', ['otp' => $otp]);
        $email->setMessage($message);

        $email->send();
    }

    public function logout()
    {
        if (isset($_COOKIE['remember_token'])) {
            $this->sessionModel->where('token', $_COOKIE['remember_token'])->delete();
            setcookie('remember_token', '', time() - 3600, '/');
        }

        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
