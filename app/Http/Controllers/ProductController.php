<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB; 


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

        $releaseYears = Product::distinct()
        ->whereNotNull('release_year')
        ->pluck('release_year')
        ->sort()
        ->values()
        ->all();

        $products = $productsQuery->paginate(12);

        return view('products', compact('products', 'releaseYears'));
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
        
        $products = Product::where(function($q) use ($query) {
            $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($query).'%'])
            ->orWhereRaw('LOWER(description) LIKE ?', ['%'.strtolower($query).'%']);
        })->paginate(12);
        
        $releaseYears = Product::distinct()->orderBy('release_year', 'desc')->pluck('release_year')->toArray();
        
        return view('products', compact('products', 'releaseYears'));
    }

    public function store(Request $request)
    {
        try {
            if (!$request->hasFile('images')) {
                return redirect()->back()->with('error', 'No images were uploaded. Please select at least one image.');
            }
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'release_year' => 'nullable|numeric',
            ]);
            
            $folderName = strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-\s]/', '', $request->name)));
            $fullPath = public_path('pictures/' . $folderName);
            
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0777, true)) {
                    return redirect()->back()->with('error', 'Server error: Could not create upload directory');
                }
            }
            
            $imagesPaths = [];
            $files = $request->file('images');
            
            foreach ($files as $index => $file) {
                if (!$file->isValid()) {
                    continue; 
                }
                
                $filename = $index . '.' . $file->getClientOriginalExtension();

                if ($file->move($fullPath, $filename)) {
                    $imagesPaths[] = $folderName . '/' . $filename;
                } 
            }
        
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'images' => json_encode($imagesPaths),
                'release_year' => $request->release_year,
                'platforms' => $request->platforms ?? [],
                'genres' => $request->genres ?? [],
            ]);
            
            
            return redirect()->back()->with('success', 'Product added successfully with ' . count($imagesPaths) . ' images!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|numeric|exists:products,id'
            ]);
            
            $product = Product::findOrFail($request->product_id);

            $product->delete();            
            
            return redirect()->back()->with('success', 'Product deleted successfully from database.');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Product not found.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {        
        try {
            $request->validate([
                'product_id' => 'required|numeric|exists:products,id'
            ]);
            
            $product = Product::findOrFail($request->product_id);
            
            if ($request->filled('name')) {
                $product->name = $request->name;
            }
            
            if ($request->filled('description')) {
                $product->description = $request->description;
            }
            
            if ($request->filled('price')) {
                $product->price = $request->price;
            }
            
            if ($request->filled('release_year')) {
                $product->release_year = $request->release_year;
            }
            
            if ($request->has('platforms')) {
                $product->platforms = $request->platforms ?? [];
            }
            
            if ($request->has('genres')) {
                $product->genres = $request->genres ?? [];
            }
            if ($request->hasFile('images')) {
                $folderName = strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9\-\s]/', '', $product->name)));
                $fullPath = public_path('pictures/' . $folderName);
                
                if (!file_exists($fullPath)) {
                    if (!mkdir($fullPath, 0777, true)) {
                        return redirect()->back()->with('error', 'Server error: Could not create upload directory');
                    }
                }
                
                $imagesPaths = [];
                $files = $request->file('images');
                
                foreach ($files as $index => $file) {
                    if (!$file->isValid()) {
                        continue; 
                    }
                    
                    $filename = $index . '.' . $file->getClientOriginalExtension();

                    if ($file->move($fullPath, $filename)) {
                        $imagesPaths[] = $folderName . '/' . $filename;
                    } 
                }
            
                $product->images = json_encode($imagesPaths);
            }
            
            $product->save();
            
            return redirect()->back()->with('success', 'Product updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }
}