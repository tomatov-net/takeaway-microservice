<?php

use Illuminate\Database\Seeder;

class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurants = \App\Models\Restaurant::all();
        foreach ($restaurants as $restaurant) {

            /*create a delivery time only when it doesn't exist*/
            $time = round(rand(10, 150)/5) * 5;

            \App\Models\DeliveryTime::firstOrCreate([
                'restaurant_id' => $restaurant->id,
            ],[
                'restaurant_id' => $restaurant->id,
                'delivery_time' => $time,
            ]);
        }
    }
}
