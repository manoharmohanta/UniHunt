<?php

namespace App\Models\TestPrep;

use CodeIgniter\Model;

class ExamResourceModel extends Model
{
    protected $table = 'test_prep_resources';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['module_id', 'title', 'type', 'media_path', 'content'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}
