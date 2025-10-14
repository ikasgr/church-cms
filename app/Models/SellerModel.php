<?php

namespace App\Models;

use CodeIgniter\Model;

class SellerModel extends Model
{
    protected $table = 'sellers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id', 'business_name', 'owner_name', 'email', 'phone', 'password',
        'address', 'description', 'logo', 'bank_name', 'bank_account_number',
        'bank_account_name', 'status', 'is_verified', 'commission_rate',
        'total_sales', 'total_products', 'rating', 'total_reviews'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getWithStats($id = null)
    {
        $builder = $this->select('sellers.*, 
            COUNT(DISTINCT products.id) as product_count,
            COUNT(DISTINCT order_items.id) as order_count,
            COALESCE(SUM(order_items.seller_income), 0) as total_income')
            ->join('products', 'products.seller_id = sellers.id', 'left')
            ->join('order_items', 'order_items.seller_id = sellers.id AND order_items.status = "completed"', 'left')
            ->groupBy('sellers.id');

        if ($id) {
            return $builder->where('sellers.id', $id)->first();
        }

        return $builder->findAll();
    }

    public function updateTotalSales($sellerId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('order_items');
        
        $result = $builder->select('SUM(seller_income) as total')
            ->where('seller_id', $sellerId)
            ->where('status', 'completed')
            ->get()
            ->getRow();

        $this->update($sellerId, ['total_sales' => $result->total ?? 0]);
    }

    public function updateTotalProducts($sellerId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products');
        
        $count = $builder->where('seller_id', $sellerId)
            ->where('deleted_at', null)
            ->countAllResults();

        $this->update($sellerId, ['total_products' => $count]);
    }
}
