<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
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

        DB::table('order_product')->truncate();
        DB::table('orders')->truncate();
        DB::table('users')->truncate();
        

        User::create([
            'username' => 'guest',
            'full_name' => 'Guest',
            'email' => 'guest@guest.com',
            'password' => 'guest',
        ]);
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

        User::create([
            'username' => 'admin',
            'full_name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'is_admin' => true
        ]);
    
        $order1 = Order::create([
            'user_id' => 2,
            'order_status' => 'pending',
            'payment_method' => 'Credit Card',
            'delivery_method' => 'Courier',
            'delivery_address' => '123 Main St, Cityville',
            'delivery_status' => 'Preparing',
        ]);

        $order2 = Order::create([
            'user_id' => 2,
            'order_status' => 'completed',
            'payment_method' => 'PayPal',
            'delivery_method' => 'Courier',
            'delivery_address' => '123 Main St, Cityville',
            'delivery_status' => 'Delivered',
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
            'user_id' => 3,
            'order_status' => 'pending',
            'payment_method' => 'Bank Transfer',
            'delivery_method' => 'Pickup Point',
            'delivery_address' => '456 Side St, Townburg',
            'delivery_status' => 'Awaiting Pickup',
        ]);

        $order3->products()->attach([
            6 => ['quantity' => 1, 'price' => Product::find(6)->price],
            7 => ['quantity' => 4, 'price' => Product::find(7)->price],
            8 => ['quantity' => 3, 'price' => Product::find(8)->price],
        ]);
    }
}
