<?php

use Tests\TestCase;
use App\Models\Order;
use App\Services\OrderService;
use App\Repositories\OrderRepository;

class OrderTest extends TestCase
{
    /**
     * Test getMealOrdersByOrderId function.
     *
     * @return void
     */
    public function testGetMealOrdersByOrderId()
    {
        $result = (new OrderService(new OrderRepository(new Order)))->getMealOrdersByOrderId(5);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('mealGroups', $result);
        $this->assertArrayHasKey('orderDetails', $result);
        $this->assertArrayHasKey('mealTitle', $result);
        $this->assertArrayHasKey('orderPrice', $result);
        $this->assertEquals('Dinner and Breakfast', $result['mealTitle']);
    }
}
