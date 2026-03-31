<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'brand' => 'Tom Ford',
                'name' => 'Oud Wood',
                'short_description' => 'Warm woods, cardamom, and amber in an elegant signature profile.',
                'description' => 'A premium evening fragrance with a polished woody-spicy trail and refined depth.',
                'image_url' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=900&q=80',
                'price' => 289,
                'currency' => 'USD',
                'stock' => 15,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'brand' => 'Salvatore Ferragamo',
                'name' => 'Signorina',
                'short_description' => 'Chic floral-fruity notes with soft sweetness and polished femininity.',
                'description' => 'A feminine designer fragrance with a bright opening and an elegant creamy finish.',
                'image_url' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?auto=format&fit=crop&w=900&q=80',
                'price' => 119,
                'currency' => 'USD',
                'stock' => 22,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'brand' => 'Dior',
                'name' => 'Sauvage Elixir',
                'short_description' => 'Fresh spice, woods, and rich aromatic intensity.',
                'description' => 'A bold masculine scent for customers who want projection, longevity, and luxury appeal.',
                'image_url' => 'https://images.unsplash.com/photo-1615634262417-2d7d7c0a3a0f?auto=format&fit=crop&w=900&q=80',
                'price' => 210,
                'currency' => 'USD',
                'stock' => 10,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'brand' => 'Maison Francis Kurkdjian',
                'name' => 'Baccarat Rouge 540',
                'short_description' => 'Amber, saffron, cedar, and airy sweetness.',
                'description' => 'A luxury bestseller with a recognizable radiant scent cloud and strong prestige pull.',
                'image_url' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&w=900&q=80',
                'price' => 349,
                'currency' => 'USD',
                'stock' => 7,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'brand' => 'Yves Saint Laurent',
                'name' => 'Libre Intense',
                'short_description' => 'Orange blossom, lavender, vanilla, and warm amber.',
                'description' => 'A glamorous designer scent with rich sweetness and modern confidence.',
                'image_url' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=900&q=80',
                'price' => 168,
                'currency' => 'USD',
                'stock' => 14,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'brand' => 'Creed',
                'name' => 'Aventus',
                'short_description' => 'Pineapple, smoky woods, musk, and refined power.',
                'description' => 'A prestigious masculine icon with broad recognition and an elevated luxury image.',
                'image_url' => 'https://images.unsplash.com/photo-1563170351-be82bc888aa4?auto=format&fit=crop&w=900&q=80',
                'price' => 395,
                'currency' => 'USD',
                'stock' => 6,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 6,
            ],
            [
                'brand' => 'Parfums de Marly',
                'name' => 'Delina',
                'short_description' => 'Rose, lychee, rhubarb, and soft creamy musk.',
                'description' => 'A luxury feminine favorite known for elegance, brightness, and memorable trail.',
                'image_url' => 'https://images.unsplash.com/photo-1587017539504-67cfbddac569?auto=format&fit=crop&w=900&q=80',
                'price' => 330,
                'currency' => 'USD',
                'stock' => 9,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'brand' => 'Initio',
                'name' => 'Side Effect',
                'short_description' => 'Rum, tobacco, cinnamon, and dark vanilla warmth.',
                'description' => 'A seductive niche fragrance suited for statement evenings and luxury gifting.',
                'image_url' => 'https://images.unsplash.com/photo-1590736969955-71cc94901144?auto=format&fit=crop&w=900&q=80',
                'price' => 315,
                'currency' => 'USD',
                'stock' => 8,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 8,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                [
                    'brand' => $product['brand'],
                    'name' => $product['name'],
                ],
                $product
            );
        }
    }
}
