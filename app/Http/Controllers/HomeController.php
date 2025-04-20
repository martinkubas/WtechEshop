<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $topGames = Product::orderBy('price', 'desc')->get(); 

        $uniqueGames = [];
        $firstWords = []; 
    
        foreach ($topGames as $game) {
            $firstWord = $this->getFirstWord($game->name);

            if (!in_array($firstWord, $firstWords)) {
                $uniqueGames[] = $game;
                $firstWords[] = $firstWord; 
            }

            if (count($uniqueGames) >= 3) {
                break;
            }
        }
    
        return view('home', compact('uniqueGames'));
    }
    private function getFirstWord($name)
    {
        $words = explode(' ', trim($name)); 
        return strtolower($words[0]); 
    }
}
