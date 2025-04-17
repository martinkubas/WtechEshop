<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $sortOption = $request->input('sort', 'recomended'); 

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $releaseYear = $request->input('release_year');
        $platforms = $request->input('platforms', []);
        $genres = $request->input('genres', []);

        $productsQuery = Product::query();

        if ($minPrice) {
            $productsQuery->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        if ($releaseYear) {
            $productsQuery->where('release_year', $releaseYear);
        }

        if (!empty($platforms)) {
            $productsQuery->where(function ($query) use ($platforms) {
                foreach ($platforms as $platform) {
                    $query->orWhereJsonContains('platforms', $platform);
                }
            });
        }


        if (!empty($genres)) {
            $productsQuery->where(function ($query) use ($genres) {
                foreach ($genres as $genre) {
                    $query->orWhereJsonContains('genres', $genre);
                }
            });
        }


        switch ($sortOption) {
            case 'best_selling':
                $productsQuery->inRandomOrder(); 
                break;

            case 'recomended':
                $productsQuery->orderBy('name', 'asc'); 
                break;

            case 'lowest_price':
                $productsQuery->orderBy('price', 'asc'); 
                break;

            case 'highest_price':
                $productsQuery->orderBy('price', 'desc'); 
                break;
            case 'created_at':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            default:
                $productsQuery->orderBy('name', 'asc');
                break;
        }

        $products = $productsQuery->paginate(12);

        return view('products', compact('products'));
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404);
        }

        return view('products.show', compact('product'));    
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products =  Product::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($query) . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($query) . '%'])
                    ->paginate(12);  

        return view('products', compact('products', 'query'));
    }
}