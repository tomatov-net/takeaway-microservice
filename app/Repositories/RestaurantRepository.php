<?php


namespace App\Repositories;


use App\Models\Restaurant;

class RestaurantRepository
{
    public static function find($id)
    {
        return Restaurant::find($id);
    }

    public function getDeliveryTime(Restaurant $restaurant)
    {
        return $restaurant->delivery_time->delivery_time;
    }
}
