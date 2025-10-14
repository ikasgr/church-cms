<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'seller_id', 'category_id', 'name', 'slug', 'description',
        'price', 'discount_price', 'stock', 'unit', 'min_order', 'weight', 'sku',
        'images', 'is_featured', 'is_active', 'views', 'sold_count',
        'rating', 'total_reviews', 'meta_keywords', 'meta_description'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    public function getWithDetails($id = null)
    {
        $builder = $this->select('products.*, 
            sellers.business_name as seller_name,
            sellers.logo as seller_logo,
            sellers.rating as seller_rating,
            product_categories.name as category_name')
            ->join('sellers', 'sellers.id = products.seller_id', 'left')
            ->join('product_categories', 'product_categories.id = products.category_id', 'left');

        if ($id) {
            return $builder->where('products.id', $id)->first();
        }

        return $builder->findAll();
    }

    public function getPublicProducts($filters = [])
    {
        $builder = $this->select('products.*, 
            sellers.business_name as seller_name,
            product_categories.name as category_name')
            ->join('sellers', 'sellers.id = products.seller_id AND sellers.status = "active"', 'left')
            ->join('product_categories', 'product_categories.id = products.category_id', 'left')
            ->where('products.is_active', 1)
            ->where('products.deleted_at', null);

        if (isset($filters['category_id'])) {
            $builder->where('products.category_id', $filters['category_id']);
        }

        if (isset($filters['seller_id'])) {
            $builder->where('products.seller_id', $filters['seller_id']);
        }

        if (isset($filters['search'])) {
            $builder->groupStart()
                ->like('products.name', $filters['search'])
                ->orLike('products.description', $filters['search'])
                ->groupEnd();
        }

        if (isset($filters['min_price'])) {
            $builder->where('products.price >=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $builder->where('products.price <=', $filters['max_price']);
        }

        if (isset($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $builder->orderBy('products.price', 'ASC');
                    break;
                case 'price_desc':
                    $builder->orderBy('products.price', 'DESC');
                    break;
                case 'popular':
                    $builder->orderBy('products.sold_count', 'DESC');
                    break;
                case 'rating':
                    $builder->orderBy('products.rating', 'DESC');
                    break;
                default:
                    $builder->orderBy('products.created_at', 'DESC');
            }
        } else {
            $builder->orderBy('products.created_at', 'DESC');
        }

        return $builder->findAll();
    }

    public function incrementViews($id)
    {
        $this->set('views', 'views+1', false)->where('id', $id)->update();
    }

    public function updateStock($id, $quantity)
    {
        $product = $this->find($id);
        if ($product) {
            $newStock = $product['stock'] - $quantity;
            $this->update($id, ['stock' => $newStock]);
        }
    }

    public function updateSoldCount($id, $quantity)
    {
        $this->set('sold_count', 'sold_count+' . $quantity, false)->where('id', $id)->update();
    }
}
