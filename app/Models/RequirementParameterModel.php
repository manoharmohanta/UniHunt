<?php

namespace App\Models;

use CodeIgniter\Model;

class RequirementParameterModel extends Model
{
    protected $table = 'requirement_parameters';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['id', 'code', 'label', 'country_id', 'applies_to', 'type', 'category_tags'];

    // Dates
    protected $useTimestamps = false;
}
