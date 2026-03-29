<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Models\ApiTokenModel;

class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        
        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Unauthorized. Bearer token required.'])
                ->setStatusCode(401);
        }

        $token = $matches[1];
        $tokenModel = new ApiTokenModel();
        
        $apiToken = $tokenModel->where('token', $token)
                               ->where('expires_at >', date('Y-m-d H:i:s'))
                               ->first();

        if (!$apiToken) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Invalid or expired token.'])
                ->setStatusCode(401);
        }

        // Update last used
        $tokenModel->update($apiToken['id'], ['last_used_at' => date('Y-m-d H:i:s')]);

        // Add user_id to request object for use in controllers
        $request->user_id = $apiToken['user_id'];
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
