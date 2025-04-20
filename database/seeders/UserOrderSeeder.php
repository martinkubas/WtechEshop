<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class UserOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'john_doe',
            'full_name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);
    
        User::create([
            'username' => 'jane_doe',
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
        ]);
    
        $order1 = Order::create([
            'user_id' => 1, 
            'order_status' => 'pending',
        ]);
    
        $order2 = Order::create([
            'user_id' => 1, 
            'order_status' => 'completed',
        ]);
    
        $order1->products()->attach([
            1 => ['quantity' => 2, 'price' => Product::find(1)->price],
            2 => ['quantity' => 1, 'price' => Product::find(2)->price],
            3 => ['quantity' => 5, 'price' => Product::find(3)->price],
        ]);
    
        $order2->products()->attach([
            4 => ['quantity' => 3, 'price' => Product::find(4)->price],
            5 => ['quantity' => 2, 'price' => Product::find(5)->price],
        ]);
    
        $order3 = Order::create([
            'user_id' => 2, 
            'order_status' => 'pending',
        ]);
    
        $order3->products()->attach([
            6 => ['quantity' => 1, 'price' => Product::find(6)->price],
            7 => ['quantity' => 4, 'price' => Product::find(7)->price],
            8 => ['quantity' => 3, 'price' => Product::find(8)->price],
        ]);
    }
}
