<?php


namespace App\Repositories;


use App\Models\Restaurant;
use Carbon\Carbon;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 */
class RestaurantRepository
{
    /**
     * Find Restaurant by id
     *
     * @param $id
     * @return Restaurant
     */
    public static function find($id): Restaurant
    {
        return Restaurant::find($id);
    }

    /**
     * Get restaurant delivery time
     *
     * @param Restaurant $restaurant
     * @return int|null
     */
    public function getDeliveryTime(Restaurant $restaurant): ?int
    {
        return $restaurant->delivery_time->delivery_time ?? null;
    }
}
