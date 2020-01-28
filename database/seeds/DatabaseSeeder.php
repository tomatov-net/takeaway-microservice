<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RestaurantSeeder::class);
         $this->call(DeliveryTimeSeeder::class);
         $this->call(MessageTypeSeeder::class);
         $this->call(RoleSeeder::class);
         $this->call(UserSeeder::class);
    }
}
