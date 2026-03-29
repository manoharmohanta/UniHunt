<?php

namespace App\Models;

use CodeIgniter\Model;

class MockInterviewModel extends Model
{
    protected $table            = 'mock_interviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'country', 'visa_type', 'transcript', 'feedback', 'score', 'created_at'];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
}
