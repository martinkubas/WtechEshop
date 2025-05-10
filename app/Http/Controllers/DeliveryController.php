<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;

class DeliveryController extends Controller
{
    public function index()
    {
        $cartItems = [];
        
        if (Auth::check()) {
            $cartItems = Auth::user()->cartItems()->with('product')->get();
        }
        
        return view('cart.delivery', compact('cartItems'));
    }
    
    public function store(Request $request)
    {
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'delivery_method' => 'required|string',
            'payment_method' => 'required|string',
            'delivery_address' => 'required_unless:delivery_method,pickup|nullable|string',
        ]);

        
        $order = new Order();
        $order->user_id = Auth::check() ? Auth::id() : 1; // user id 1 = guest
        $order->order_status = 'pending';
        $order->payment_method = $request->payment_method;
        $order->delivery_method = $request->delivery_method;
        $order->delivery_address = $request->delivery_method === 'pickup' ? 'In-store pickup' : $request->delivery_address;
        $order->delivery_status = 'Preparing';
        $order->save();
        
        
        $orderProducts = [];
        
        if (Auth::check()) {
            $cartItems = Auth::user()->cartItems()->with('product')->get();
            
            
            foreach ($cartItems as $item) {
                $orderProducts[$item->product_id] = [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ];
            }
            
            Auth::user()->cartItems()->delete();
        } else {
            $cartData = $request->input('cart_data');
            
            try {
                $cartItems = json_decode($cartData, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $cartItems = [];
                }
                
                foreach ($cartItems as $item) {
                    $orderProducts[$item['id']] = [
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ];    
                }
            } catch (\Exception $e) {
                $orderProducts = [];
            }
        }
        
        $order->products()->attach($orderProducts);
        
        return redirect()->route('order.confirmation', ['id' => $order->id]);
    }
    
    public function confirmation($id)
    {
        $order = Order::with('products')->findOrFail($id);
        return view('cart.confirmation', compact('order'));
    }
}