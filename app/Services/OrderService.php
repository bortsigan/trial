<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Models\Order;

class OrderService {

    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getMealOrdersByOrderId(Int $orderId)
    {
        $datas = $this->orderRepository->getMealOrdersByOrderId($orderId);
        $groups = [];
        $mealGroups = [];

        foreach ($datas as $data) {
            if (in_array($data->meal_type, ['drink'])) {
                if (isset($groups['drink'][$data->meal_id])) {
                    $groups['drink'][$data->meal_id]['count']++;
                } else {
                    $groups['drink'][$data->meal_id] = [
                        'meal_id' => $data->meal_id,
                        'meal_type' => $data->meal_type,
                        'meal_name' => $data->meal_name,
                        'count' => 1
                    ];
                }
            }

            if (in_array($data->meal_type, ['dinner', 'lunch', 'breakfast'])) {
                if (isset($groups['meals'][$data->meal_id])) {
                    $groups['meals'][$data->meal_id]['count']++;
                } else {
                    $groups['meals'][$data->meal_id] = [
                        'meal_id' => $data->meal_id,
                        'meal_type' => $data->meal_type,
                        'meal_name' => $data->meal_name,
                        'count' => 1
                    ];
                }
            }

            if (in_array($data->meal_type, ['snack'])) {
                if (isset($groups['snack'][$data->meal_id])) {
                    $groups['snack'][$data->meal_id]['count']++;
                } else {
                    $groups['snack'][$data->meal_id] = [
                        'meal_id' => $data->meal_id,
                        'meal_type' => $data->meal_type,
                        'meal_name' => $data->meal_name,
                        'count' => 1
                    ];
                }
            }

            if (in_array($data->meal_type, ['side'])) {

                if (isset($groups['side'][$data->meal_id])) {
                    $groups['side'][$data->meal_id]['count']++;
                } else {
                    $groups['side'][$data->meal_id] = [
                        'meal_id' => $data->meal_id,
                        'meal_type' => $data->meal_type,
                        'meal_name' => $data->meal_name,
                        'count' => 1
                    ];
                }
            }

            if (!isset($mealGroups[$data->meal_type])) {
                $mealGroups[$data->meal_type] = $data->meal_type;
            }
        }

        return [
            'mealGroups' => $mealGroups, 
            'orderDetails' => $groups, 
            'mealTitle' => $this->getMealTitleCombination($mealGroups),
            'orderPrice' => Order::find($orderId, ['price'])->price
        ];
    }

    private function getMealTitleCombination(Array $mealGroups = []) 
    {
        $text = null;
        $cnt = 0;
        foreach($mealGroups as $mg) {
            $cnt += 1;
            if (in_array($mg, ['dinner', 'lunch', 'breakfast'])) {
                $text .= ucfirst($mg); 

                if ($cnt !== sizeof($mealGroups)) {
                    $text .= " and ";
                }
            }
        }

        return $text;
    }
}