<?php

namespace App\Models\TestPrep;

use CodeIgniter\Model;

class ExamModel extends Model
{
    protected $table = 'test_prep_exams';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'slug'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
