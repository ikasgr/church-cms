<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table            = 'banners';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'image',
        'link',
        'description',
        'position',
        'is_active',
        'start_date',
        'end_date',
        'order_position'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title'    => 'required|min_length[3]|max_length[255]',
        'position' => 'required|in_list[home_slider,sidebar,header,footer]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getActive($position = null)
    {
        $builder = $this->where('is_active', 1)
                        ->where('start_date <=', date('Y-m-d'))
                        ->where('end_date >=', date('Y-m-d'))
                        ->orderBy('order_position', 'ASC');
        
        if ($position) {
            $builder->where('position', $position);
        }
        
        return $builder->findAll();
    }
}
