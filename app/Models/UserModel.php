<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'role_id',
        'university_id',
        'name',
        'email',
        'phone',
        'registered_from',
        'is_verified',
        'status',
        'marketing_consent',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false; // Using TIMESTAMP in DB with default CURRENT_TIMESTAMP
}
