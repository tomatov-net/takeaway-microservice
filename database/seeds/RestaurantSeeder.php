<?php

use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurants = [
            'FEBO',
            'Da Vinci',
            'Greetje',
            'Bord’Eau',
        ];

        foreach ($restaurants as $restaurant) {
            \App\Models\Restaurant::firstOrCreate([
                'name' => $restaurant
            ]);
        }
    }
}
