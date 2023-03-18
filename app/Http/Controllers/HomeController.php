<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Models\Order;
use App\Http\Resources\OrderResource;

class HomeController extends Controller
{
    private OrderService $orderService;
    private Order $order;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getOrders()
    {
        return OrderResource::collection(Order::select(['id', 'delivery_date', 'price'])->get());
    }
}
