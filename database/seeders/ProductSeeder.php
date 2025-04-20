<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();
        
        $baseProducts = [
            [
                'name' => 'Shadow Strike: Tokyo Reign',
                'price' => 49.99,
                'description' => 'Battle through neon-lit Tokyo in this stealth-action hybrid that blends ninjas and futuristic tech.',
                'release_year' => 2023,
                'platforms' => ['PC', 'Xbox'],
                'genres' => ['Action', 'Stealth', 'Futuristic'], 
                'images' => ['cb/1.webp', 'cb/2.webp', 'cb/3.webp'],
            ],
            [
                'name' => 'Cyber Drift: Velocity Core',
                'price' => 39.99,
                'description' => 'Race through cybernetic highways and hack your rivals mid-drift in this adrenaline-fueled racer.',
                'release_year' => 2022,
                'platforms' => ['PC', 'Playstation'], 
                'genres' => ['Racing', 'Cyberpunk'], 
                'images' => ['id/1.webp', 'id/2.webp', 'id/3.webp'],
            ],
            [
                'name' => 'Warden of the Flame',
                'price' => 59.99,
                'description' => 'Take on the mantle of the last Fire Warden to defend your realm from icy invaders in this epic RPG.',
                'release_year' => 2021,
                'platforms' => ['Playstation'], 
                'genres' => ['RPG', 'Fantasy'], 
                'images' => ['itt/1.webp', 'itt/2.webp', 'itt/3.webp'],
            ],
            [
                'name' => 'Galactic Outlaws: Rogue Sector',
                'price' => 44.99,
                'description' => 'Command a crew of rebels as you navigate uncharted galaxies and face off in space duels.',
                'release_year' => 2023,
                'platforms' => ['PC', 'Xbox'], 
                'genres' => ['Action', 'Sci-Fi'], 
                'images' => ['jp/1.webp', 'jp/2.webp', 'jp/3.webp', 'jp/4.webp'],
            ],
            [
                'name' => 'Mech Titans: Iron Uprising',
                'price' => 69.99,
                'description' => 'Pilot massive mechs in this explosive open-world experience where every building is destructible.',
                'release_year' => 2020,
                'platforms' => ['PC', 'Playstation', 'Xbox'], 
                'genres' => ['Action', 'Shooter', 'Open World'], 
                'images' => ['kcd/1.webp', 'kcd/2.webp', 'kcd/3.webp'],
            ],
            [
                'name' => 'Echoes of Atlantis',
                'price' => 54.99,
                'description' => 'Dive into the forgotten depths of Atlantis, solve ancient puzzles, and uncover lost powers.',
                'release_year' => 2021,
                'platforms' => ['PC'], 
                'genres' => ['Adventure', 'Puzzle'], 
                'images' => ['lou/1.webp', 'lou/2.webp', 'lou/3.webp', 'lou/4.webp', 'lou/5.webp'],
            ],
            [
                'name' => 'Steel Hearts: Combat Protocol',
                'price' => 34.99,
                'description' => 'A gritty, fast-paced brawler set in a dystopian future where androids fight for freedom.',
                'release_year' => 2022,
                'platforms' => ['Playstation'], 
                'genres' => ['Fighting', 'Sci-Fi'], 
                'images' => ['mc/1.webp', 'mc/2.webp'],
            ],
            [
                'name' => 'Phantom Reign',
                'price' => 64.99,
                'description' => 'A dark fantasy game where you control shadows and manipulate fear to conquer kingdoms.',
                'release_year' => 2023,
                'platforms' => ['PC', 'Xbox'], 
                'genres' => ['Action', 'Fantasy'], 
                'images' => ['sf/1.webp', 'sf/2.webp', 'sf/3.webp', 'sf/4.webp'],
            ],
            [
                'name' => 'Nova Blasters: Core War',
                'price' => 29.99,
                'description' => 'Blast your way through interstellar wars with high-tech weaponry in this top-down shooter.',
                'release_year' => 2021,
                'platforms' => ['PC'],
                'genres' => ['Shooter', 'Sci-Fi'], 
                'images' => ['spiderman/1.webp', 'spiderman/2.webp', 'spiderman/3.webp', 'spiderman/4.webp', 'spiderman/5.webp'],
            ],
            [
                'name' => 'Chrono Drift: Time Racers',
                'price' => 42.99,
                'description' => 'Race through history and bend time to win—literally—in this timeline-bending arcade racer.',
                'release_year' => 2023,
                'platforms' => ['Playstation'], 
                'genres' => ['Racing', 'Time Travel'], 
                'images' => ['stalker/1.webp', 'stalker/2.webp', 'stalker/3.webp', 'stalker/4.webp'],
            ]
        ];
    
       

        foreach ($baseProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'description' => $product['description'],
                'release_year' => $product['release_year'], 
                'platforms' => json_encode($product['platforms']), 
                'genres' => json_encode($product['genres']), 
                'images' => json_encode($product['images'])
            ]);
        }

        foreach ($baseProducts as $product) {
            Product::create([
                'name' => $product['name'] . ' II',
                'price' => $product['price'],
                'description' => $product['description'],
                'release_year' => $product['release_year'],
                'platforms' => json_encode($product['platforms']), 
                'genres' => json_encode($product['genres']), 
                'images' => json_encode($product['images'])
            ]);
        }

        
        
        
    }
}
