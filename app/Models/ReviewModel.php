<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'university_id',
        'user_id',
        'reviewer_name',
        'reviewer_designation',
        'rating',
        'comment',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getApprovedReviewsByUniversity($universityId)
    {
        return $this->where('university_id', $universityId)
            ->where('status', 'approved')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
