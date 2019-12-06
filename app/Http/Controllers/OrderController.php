<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderConfirmRequest;
use App\Http\Requests\OrderCreateRequest;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * @param OrderCreateRequest $request
     * @param OrderRepository $orderRepository
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(OrderCreateRequest $request, OrderRepository $orderRepository): JsonResponse
    {
        $orderData = [
            'restaurant_id' => $request->restaurant_id,
            'client_phone_number' => $request->client_phone_number,
            'client_name' => $request->client_name,
            'order_details' => $request->order_details,
        ];

        $orderRepository->create($orderData);

        return response()->json(['message' => 'Order has been created']);
    }

    /**
     * @param OrderConfirmRequest $request
     * @param int $orderId
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     */
    public function confirm(OrderConfirmRequest $request, int $orderId, OrderRepository $orderRepository): JsonResponse
    {
        $orderRepository->confirm($orderId);

        return response()->json(['message' => 'Order has been confirmed']);
    }

    /**
     * @param Request $request
     * @param int $orderId
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     */
    public function deliver(Request $request, int $orderId, OrderRepository $orderRepository): JsonResponse
    {
        $orderRepository->deliver($orderId);
        return response()->json(['message' => 'Order has been delivered']);
    }

    /**
     * @param Request $request
     * @param int $orderId
     */
    public function cancel(Request $request, int $orderId)
    {
        /*todo implement logic*/
    }
}
