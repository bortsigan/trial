<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;

class OrderRepository {

    private Order $order;

    public function __construct(Order $order) {
        $this->order = $order;
    }

    public function getMealOrdersByOrderId(Int $orderId) 
    {
        return $this->order
                ->select([
                    'meals.id as meal_id',
                    'meals.meal_name as meal_name',
                    'products_structure.meal_type as meal_type',
                    'orders.price'
                ])
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('products_structure', 'products_structure.product_id', '=', 'order_items.product_id')
                ->join('subscriptions_selections', function($join) use ($orderId) {
                    $join
                        ->on('subscriptions_selections.subscription_cycle_id', '=', 'order_items.subscription_cycle_id')
                        ->on('subscriptions_selections.product_id', '=', 'order_items.product_id');
                })
                ->join('meals', 'meals.id', '=', 'subscriptions_selections.meal_id')
                ->where('orders.id', '=', $orderId)
                ->get();
    }

    public function getOrdersByUserId(User $user, ?Array $columns = [])
    {
        return $this->order
                ->select($columns ? $columns : 'orders.*')
                ->where('user_id', $user->id)
                ->get();
    }
}