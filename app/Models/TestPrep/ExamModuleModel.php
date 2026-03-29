<?php

namespace App\Models\TestPrep;

use CodeIgniter\Model;

class ExamModuleModel extends Model
{
    protected $table = 'test_prep_modules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['exam_id', 'name', 'slug'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
