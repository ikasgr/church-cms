<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductCategoryModel extends Model
{
    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'slug', 'description', 'icon', 'order_position', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getWithProductCount()
    {
        return $this->select('product_categories.*, COUNT(products.id) as product_count')
            ->join('products', 'products.category_id = product_categories.id AND products.deleted_at IS NULL', 'left')
            ->groupBy('product_categories.id')
            ->orderBy('product_categories.order_position', 'ASC')
            ->findAll();
    }

    public function getActive()
    {
        return $this->where('is_active', 1)
            ->orderBy('order_position', 'ASC')
            ->findAll();
    }
}
