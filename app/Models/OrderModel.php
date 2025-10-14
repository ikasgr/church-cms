<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'customer_address', 'customer_notes', 'subtotal', 'shipping_cost',
        'discount', 'total', 'payment_method', 'payment_proof', 'status', 'notes',
        'confirmed_at', 'shipped_at', 'completed_at', 'cancelled_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function getWithItems($id = null)
    {
        $builder = $this->select('orders.*')
            ->groupBy('orders.id');

        if ($id) {
            $order = $builder->where('orders.id', $id)->first();
            if ($order) {
                $order['items'] = $this->getOrderItems($id);
            }
            return $order;
        }

        $orders = $builder->findAll();
        foreach ($orders as &$order) {
            $order['items'] = $this->getOrderItems($order['id']);
        }
        return $orders;
    }

    public function getOrderItems($orderId)
    {
        $db = \Config\Database::connect();
        return $db->table('order_items')
            ->select('order_items.*, products.images, sellers.business_name as seller_name')
            ->join('products', 'products.id = order_items.product_id', 'left')
            ->join('sellers', 'sellers.id = order_items.seller_id', 'left')
            ->where('order_items.order_id', $orderId)
            ->get()
            ->getResultArray();
    }

    public function getSellerOrders($sellerId)
    {
        $db = \Config\Database::connect();
        return $db->table('orders')
            ->select('orders.*, order_items.id as item_id, order_items.product_name, 
                order_items.quantity, order_items.subtotal, order_items.status as item_status')
            ->join('order_items', 'order_items.order_id = orders.id')
            ->where('order_items.seller_id', $sellerId)
            ->orderBy('orders.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function updateStatus($id, $status)
    {
        $data = ['status' => $status];
        
        switch ($status) {
            case 'confirmed':
                $data['confirmed_at'] = date('Y-m-d H:i:s');
                break;
            case 'shipped':
                $data['shipped_at'] = date('Y-m-d H:i:s');
                break;
            case 'completed':
                $data['completed_at'] = date('Y-m-d H:i:s');
                break;
            case 'cancelled':
                $data['cancelled_at'] = date('Y-m-d H:i:s');
                break;
        }

        return $this->update($id, $data);
    }
}
