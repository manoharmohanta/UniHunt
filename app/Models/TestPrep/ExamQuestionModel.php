<?php

namespace App\Models\TestPrep;

use CodeIgniter\Model;

class ExamQuestionModel extends Model
{
    protected $table = 'test_prep_questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['module_id', 'resource_id', 'question_text', 'media_path', 'type', 'options', 'correct_answer'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected array $casts = [
        'options' => 'json'
    ];
}
