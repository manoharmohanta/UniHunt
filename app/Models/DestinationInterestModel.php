<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationInterestModel extends Model
{
    protected $table = 'destination_interest';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['country_slug', 'ip_address', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
}
