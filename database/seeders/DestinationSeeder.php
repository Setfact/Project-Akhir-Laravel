<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $wisata = [
            ['name' => 'Pantai Bara', 'price' => 15000, 'img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800'],
            ['name' => 'Tebing Apparallang', 'price' => 20000, 'img' => 'https://images.unsplash.com/photo-1506953823976-52e1fdc0149a?w=800'],
            ['name' => 'Bukit Donggia', 'price' => 10000, 'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800'],
            ['name' => 'Pantai Mandalaria', 'price' => 15000, 'img' => 'https://images.unsplash.com/photo-1590523277543-a94d2e4eb00b?w=800'],
            ['name' => 'Pulau Kambing', 'price' => 50000, 'img' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=800'],
        ];

        foreach ($wisata as $w) {
            Destination::create([
                'name' => $w['name'],
                'slug' => Str::slug($w['name']),
                'description' => 'Nikmati keindahan alam ' . $w['name'] . ' yang mempesona di Bulukumba. Cocok untuk liburan keluarga.',
                'location' => 'Kabupaten Bulukumba, Sulawesi Selatan',
                'price' => $w['price'],
                'image_url' => $w['img'],
            ]);
        }
    }
}