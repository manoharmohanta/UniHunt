<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class HtmxFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // No action needed before
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Always send new CSRF token in header for HTMX requests
        if ($request->hasHeader('HX-Request') || $request->hasHeader('X-Requested-With')) {
            $response->setHeader('X-CSRF-TOKEN', csrf_hash());
        }
    }
}
