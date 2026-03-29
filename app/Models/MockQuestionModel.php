<?php

namespace App\Models;

use CodeIgniter\Model;

class MockQuestionModel extends Model
{
    protected $table = 'mock_questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'test_type',
        'section',
        'content',
        'options',
        'correct_answer',
        'difficulty',
        'created_at',
    ];

    protected $useTimestamps = false;
}
