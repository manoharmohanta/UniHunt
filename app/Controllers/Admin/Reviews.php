<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReviewModel;

class Reviews extends BaseController
{
    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');

        $query = $this->reviewModel->select('reviews.*, universities.name as university_name')
            ->join('universities', 'universities.id = reviews.university_id');

        if ($status) {
            $query->where('reviews.status', $status);
        }

        $reviews = $query->orderBy('reviews.created_at', 'DESC')->findAll();

        return view('admin/reviews/index', [
            'title' => 'Manage Student Reviews',
            'reviews' => $reviews,
            'currentStatus' => $status
        ]);
    }

    public function update_status()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!in_array($status, ['approved', 'pending', 'rejected'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        if ($this->reviewModel->update($id, ['status' => $status])) {
            return redirect()->back()->with('success', 'Review status updated.');
        }

        return redirect()->back()->with('error', 'Failed to update status.');
    }

    public function delete($id)
    {
        if ($this->reviewModel->delete($id)) {
            return redirect()->back()->with('success', 'Review deleted successfully.');
        }
        return redirect()->back()->with('error', 'Failed to delete review.');
    }
}
