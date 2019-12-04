<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @param Request $request
     * @param int $restaurantId
     */
    public function create(Request $request, int $restaurantId)
    {

    }

    /**
     * @param Request $request
     * @param int $orderId
     */
    public function confirm(Request $request, int $orderId)
    {

    }

    /**
     * @param Request $request
     * @param int $orderId
     */
    public function deliver(Request $request, int $orderId)
    {

    }

    /**
     * @param Request $request
     * @param int $orderId
     */
    public function cancel(Request $request, int $orderId)
    {

    }
}
