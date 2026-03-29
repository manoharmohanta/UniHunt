<?php

namespace App\Models;

use CodeIgniter\Model;

class AdsModel extends Model
{
    protected $table = 'ads';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'tracking_id',
        'source_type',
        'network_name',
        'ad_content',
        'format',
        'placement',
        'start_date',
        'end_date',
        'total_days',
        'targeting',
        'frequency_capping',
        'status',
        'impressions',
        'clicks',
        'user_id',
        'price_paid'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = []; // Add validation logic later
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}
