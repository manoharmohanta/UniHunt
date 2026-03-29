<?php

namespace App\Models;

use CodeIgniter\Model;

class VisaKnowledgeBaseModel extends Model
{
    protected $table            = 'visa_knowledge_base';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'country', 
        'visa_type', 
        'document_checklist', 
        'travel_plan', 
        'places_to_visit', 
        'things_to_carry',
        'useful_links',
        'image_keyword'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
