<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    protected $format = 'json';

    protected function success($data = null, $message = 'Success', $code = 200)
    {
        return $this->respond([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    protected function error($message = 'Error', $code = 400, $data = null)
    {
        return $this->respond([
            'status'  => 'error',
            'message' => $message,
            'data'    => $data
        ], $code);
    }
}
