<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CouponModel;

class CouponController extends BaseController
{
    protected $couponModel;

    public function __construct()
    {
        $this->couponModel = new CouponModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');

        if ($search) {
            $this->couponModel->like('code', $search)
                ->orLike('description', $search);
        }

        $data = [
            'title' => 'Coupon Management',
            'coupons' => $this->couponModel->orderBy('created_at', 'DESC')->paginate(20),
            'pager' => $this->couponModel->pager->only(['search']),
            'search' => $search
        ];
        return view('admin/coupons/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Create New Coupon',
        ];
        return view('admin/coupons/create', $data);
    }

    public function create()
    {
        $rules = [
            'code' => 'required|is_unique[coupons.code]|min_length[3]|max_length[50]',
            'discount_type' => 'required|in_list[percentage,fixed]',
            'discount_value' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $input = $this->request->getPost();

        // Handle nulls for empty numeric inputs
        $usageLimit = $input['usage_limit'] === '' ? null : $input['usage_limit'];
        $usageLimitPerUser = $input['usage_limit_per_user'] === '' ? null : $input['usage_limit_per_user'];
        $startsAt = $input['starts_at'] === '' ? null : $input['starts_at'];
        $expiresAt = $input['expires_at'] === '' ? null : $input['expires_at'];

        $data = [
            'code' => strtoupper($input['code']),
            'description' => $input['description'],
            'discount_type' => $input['discount_type'],
            'discount_value' => $input['discount_value'],
            'min_purchase_amount' => $input['min_purchase_amount'] ?: 0,
            'max_discount_amount' => $input['max_discount_amount'] ?: null,
            'usage_limit' => $usageLimit,
            'usage_limit_per_user' => $usageLimitPerUser,
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
            'status' => 'active',
        ];

        if ($this->couponModel->insert($data)) {
            return redirect()->to('admin/coupons')->with('message', 'Coupon created successfully.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->couponModel->errors());
        }
    }

    public function delete($id)
    {
        $this->couponModel->delete($id);
        return redirect()->to('admin/coupons')->with('message', 'Coupon deleted successfully.');
    }
}
