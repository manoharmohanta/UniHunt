<?php

namespace App\Models;

use CodeIgniter\Model;

class UserAcademicProfileModel extends Model
{
    protected $table = 'user_academic_profiles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'academic_data',
        'course_choice',
        'target_level',
        'target_country',
        'ielts_score',
        'gre_score',
        'backlogs',
        'is_15_years_education',
        'stem_interest'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
