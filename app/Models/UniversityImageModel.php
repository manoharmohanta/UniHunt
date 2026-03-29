<?php

namespace App\Models;

use CodeIgniter\Model;

class UniversityImageModel extends Model
{
    protected $table = 'university_images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'university_id',
        'file_name',
        'image_type',
        'caption',
        'is_main',
        'uploaded_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
