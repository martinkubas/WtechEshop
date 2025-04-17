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
            ],
            [
                'name' => 'Cyber Drift: Velocity Core',
                'price' => 39.99,
                'description' => 'Race through cybernetic highways and hack your rivals mid-drift in this adrenaline-fueled racer.',
                'release_year' => 2022,
                'platforms' => ['PC', 'Playstation'], 
                'genres' => ['Racing', 'Cyberpunk'], 
            ],
            [
                'name' => 'Warden of the Flame',
                'price' => 59.99,
                'description' => 'Take on the mantle of the last Fire Warden to defend your realm from icy invaders in this epic RPG.',
                'release_year' => 2021,
                'platforms' => ['Playstation'], 
                'genres' => ['RPG', 'Fantasy'], 
            ],
            [
                'name' => 'Galactic Outlaws: Rogue Sector',
                'price' => 44.99,
                'description' => 'Command a crew of rebels as you navigate uncharted galaxies and face off in space duels.',
                'release_year' => 2023,
                'platforms' => ['PC', 'Xbox'], 
                'genres' => ['Action', 'Sci-Fi'], 
            ],
            [
                'name' => 'Mech Titans: Iron Uprising',
                'price' => 69.99,
                'description' => 'Pilot massive mechs in this explosive open-world experience where every building is destructible.',
                'release_year' => 2020,
                'platforms' => ['PC', 'Playstation', 'Xbox'], 
                'genres' => ['Action', 'Shooter', 'Open World'], 
            ],
            [
                'name' => 'Echoes of Atlantis',
                'price' => 54.99,
                'description' => 'Dive into the forgotten depths of Atlantis, solve ancient puzzles, and uncover lost powers.',
                'release_year' => 2021,
                'platforms' => ['PC'], 
                'genres' => ['Adventure', 'Puzzle'], 
            ],
            [
                'name' => 'Steel Hearts: Combat Protocol',
                'price' => 34.99,
                'description' => 'A gritty, fast-paced brawler set in a dystopian future where androids fight for freedom.',
                'release_year' => 2022,
                'platforms' => ['Playstation'], 
                'genres' => ['Fighting', 'Sci-Fi'], 
            ],
            [
                'name' => 'Phantom Reign',
                'price' => 64.99,
                'description' => 'A dark fantasy game where you control shadows and manipulate fear to conquer kingdoms.',
                'release_year' => 2023,
                'platforms' => ['PC', 'Xbox'], 
                'genres' => ['Action', 'Fantasy'], 
            ],
            [
                'name' => 'Nova Blasters: Core War',
                'price' => 29.99,
                'description' => 'Blast your way through interstellar wars with high-tech weaponry in this top-down shooter.',
                'release_year' => 2021,
                'platforms' => ['PC'],
                'genres' => ['Shooter', 'Sci-Fi'], 
            ],
            [
                'name' => 'Chrono Drift: Time Racers',
                'price' => 42.99,
                'description' => 'Race through history and bend time to win—literally—in this timeline-bending arcade racer.',
                'release_year' => 2023,
                'platforms' => ['Playstation'], 
                'genres' => ['Racing', 'Time Travel'], 
            ]
        ];
    
        $imageSet = [
            'sp1.webp', 'sp2.webp', 'sp3.webp', 'sp4.webp', 'sp5.webp'
        ];

        foreach ($baseProducts as $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'description' => $product['description'],
                'release_year' => $product['release_year'], 
                'platforms' => json_encode($product['platforms']), 
                'genres' => json_encode($product['genres']), 
                'images' => $imageSet 
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
                'images' => $imageSet
            ]);
        }

        
        
        
    }
}
