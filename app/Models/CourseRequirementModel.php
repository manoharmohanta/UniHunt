<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseRequirementModel extends Model
{
    protected $table            = 'course_requirements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['course_id', 'parameter_id', 'value'];

    // Dates
    protected $useTimestamps = false;
}
