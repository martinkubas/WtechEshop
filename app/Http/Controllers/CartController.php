<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
   public function index()
    {
        $cartItems = [];
        $hasItems = false;
        
        if (Auth::check()) {
            $cartItems = Auth::user()->cartItems()->with('product')->get();
            $hasItems = $cartItems->count() > 0;
        } else {
            $hasItems = true;
        }
        
        return view('cart.index', compact('cartItems', 'hasItems'));
    }
    
   public function add(Request $request)
    {
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if (Auth::check()) {
            $userId = Auth::id();
            
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();
                
            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                $cartItem = CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
            }
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if (Auth::check()) {
            $userId = Auth::id();
            
            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();
                
            if ($cartItem) {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
            }
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => true]);
    }
    
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        if (Auth::check()) {
            $userId = Auth::id();
            
            CartItem::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->delete();
        }
        
        return response()->json(['success' => true]);
    }
    
    public function clear()
    {
        if (Auth::check()) {
            Auth::user()->cartItems()->delete();
        }
        
        return response()->json(['success' => true]);
    }
    public function count()
    {
        if (Auth::check()) {
            $count = Auth::user()->cartItems()->sum('quantity');
        } else {
            $count = 0;
        }
        
        return response()->json(['count' => $count]);
    }
}