<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'author_id',
        'title',
        'slug',
        'content',
        'status',
        'category',
        'university_id',
        'featured_image',
        'created_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
        'blog_category',
        'blog_tags'
    ];

    // Dates
    protected $useTimestamps = false;
}
