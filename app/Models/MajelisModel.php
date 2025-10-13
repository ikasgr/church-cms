<?php

namespace App\Models;

use CodeIgniter\Model;

class MajelisModel extends Model
{
    protected $table            = 'majelis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'position',
        'photo',
        'phone',
        'email',
        'bio',
        'order_position',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name'     => 'required|min_length[3]|max_length[255]',
        'position' => 'required|max_length[100]',
        'email'    => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getActiveMajelis()
    {
        return $this->where('is_active', 1)
                    ->orderBy('order_position', 'ASC')
                    ->findAll();
    }
}
