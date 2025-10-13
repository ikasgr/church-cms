<?php

namespace App\Models;

use CodeIgniter\Model;

class GreetingModel extends Model
{
    protected $table            = 'greeting';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'content',
        'author',
        'author_position',
        'author_photo',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title'           => 'required|min_length[3]|max_length[255]',
        'content'         => 'required',
        'author'          => 'required|max_length[255]',
        'author_position' => 'required|max_length[100]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getActiveGreeting()
    {
        return $this->where('is_active', 1)->first();
    }
}
