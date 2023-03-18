<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use PDF;

class OrderController extends Controller
{
    private OrderRepository $orderRepository;
    private OrderService $orderService;

    public function __construct(OrderRepository $orderRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
    }

    /**
     * Get orders
     * 
     * return Collection
     */
    public function getOrders()
    {
        $orders = $this->orderRepository->getOrdersByUserId(
            auth()->user(), 
            ['id', 'delivery_date', 'price']
        );

        return OrderResource::collection($orders);
    }

    public function getOrderDetails(Int $id)
    {
        $datas = $this->orderService->getMealOrdersByOrderId($id);

        return json_encode($datas);
    }

    public function exportOrders(Int $id)
    {
        $datas = $this->orderService->getMealOrdersByOrderId($id);

        return PDF::loadView('pdf.exportOrder', ['datas' => $datas])->download('order_history.pdf');
    
    }
}
