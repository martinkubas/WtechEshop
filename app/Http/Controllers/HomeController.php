<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $topGames = Product::orderBy('price', 'desc')->take(3)->get();
        return view('home', compact('topGames'));
    }
}
