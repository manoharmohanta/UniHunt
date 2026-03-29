<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Models\OtpModel;
use App\Models\ApiTokenModel;
use Config\Services;

class AuthController extends ApiController
{
    /**
     * POST /api/auth/send-otp
     */
    public function sendOtp()
    {
        $email = $this->request->getVar('email');
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->error('Valid email is required.');
        }

        $otp = sprintf("%06d", mt_rand(1, 999999));
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        $otpModel = new OtpModel();
        $otpModel->insert([
            'email'      => $email,
            'otp'        => $otp,
            'expires_at' => $expires_at
        ]);

        $this->sendEmailOtp($email, $otp);

        return $this->success(null, 'OTP sent successfully.');
    }

    /**
     * POST /api/auth/verify-otp
     */
    public function verifyOtp()
    {
        $email = $this->request->getVar('email');
        $otpValue = $this->request->getVar('otp');
        $deviceName = $this->request->getVar('device_name') ?: 'Mobile App';

        if (empty($email) || empty($otpValue)) {
            return $this->error('Email and OTP are required.');
        }

        $otpModel = new OtpModel();
        $dbOtp = $otpModel->where('email', $email)
                          ->where('otp', $otpValue)
                          ->where('expires_at >', date('Y-m-d H:i:s'))
                          ->orderBy('id', 'DESC')
                          ->first();

        if (!$dbOtp) {
            return $this->error('Invalid or expired OTP.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            $userId = $userModel->insert([
                'email'           => $email,
                'registered_from' => 'app',
                'is_verified'     => true,
                'status'          => 'active',
                'created_at'      => date('Y-m-d H:i:s')
            ]);
            $user = $userModel->find($userId);
        }

        // Generate Token
        $token = bin2hex(random_bytes(32));
        $tokenModel = new ApiTokenModel();
        $tokenModel->insert([
            'user_id'     => $user['id'],
            'token'       => $token,
            'device_name' => $deviceName,
            'created_at'  => date('Y-m-d H:i:s'),
            'expires_at'  => date('Y-m-d H:i:s', strtotime('+30 days'))
        ]);

        $onboardingRequired = (empty($user['name']) || empty($user['phone']));

        return $this->success([
            'token'               => $token,
            'user'                => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'phone' => $user['phone']
            ],
            'onboarding_required' => $onboardingRequired
        ], 'Authenticated successfully.');
    }

    private function sendEmailOtp($to, $otp)
    {
        $email = Services::email();
        $fromEmail = env('email');
        $fromPass = env('password');

        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => 'smtp.gmail.com',
            'SMTPUser' => $fromEmail,
            'SMTPPass' => $fromPass,
            'SMTPPort' => 587,
            'SMTPCrypto' => 'tls',
            'mailType' => 'html',
            'charset'  => 'utf-8',
        ];

        $email->initialize($config);
        $email->setFrom($fromEmail, 'UniHunt API');
        $email->setTo($to);
        $email->setSubject('Your UniHunt API Verification Code');
        
        $message = view('emails/otp', ['otp' => $otp]);
        $email->setMessage($message);
        
        $email->send();
    }
}
