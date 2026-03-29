<?php

namespace App\Models;

use CodeIgniter\Model;

class CareerPredictionModel extends Model
{
    protected $table            = 'career_predictions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'course_name', 
        'home_country', 
        'job_titles', 
        'payscales', 
        'top_mncs', 
        'career_roadmap'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
