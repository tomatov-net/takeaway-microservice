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
        $orderData = $request->getOrderData();

        $order = $orderRepository->create($orderData);

        return response()->json([
            'message' => 'Order has been created',
            'order_id' => $order->id,
            'status' => 'created'
        ]);
    }

    /**
     * @param OrderConfirmRequest $request
     * @param int $orderId
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     */
    public function confirm(OrderConfirmRequest $request, int $orderId, OrderRepository $orderRepository): JsonResponse
    {
        if (!$orderRepository->isConfirmed($orderId)) {
            $orderRepository->confirm($orderId);

            return response()->json(['message' => 'Order has been confirmed', 'status' => 'confirmed']);
        }

        return response()->json([
            "message" => "Current order has been already confirmed",
            "status" => "already_confirmed",
            "errors" => [
                "order_id" => [
                    "The order with id = {$orderId} has been already confirmed"
                ]
            ]
        ], 400);

    }

    /**
     * @param Request $request
     * @param int $orderId
     * @param OrderRepository $orderRepository
     * @return JsonResponse
     */
    public function deliver(Request $request, int $orderId, OrderRepository $orderRepository): JsonResponse
    {
        if ($orderRepository->isConfirmed($orderId) && !$orderRepository->isDelivered($orderId)) {
            $orderRepository->deliver($orderId);

            return response()->json(['message' => 'Order has been delivered', 'status' => 'delivered']);

        }

        return response()->json([
            "message" => "Current order has been already delivered",
            "status" => "already_delivered",
            "errors" => [
                "order_id" => [
                    "The order with id = {$orderId} has been already delivered"
                ]
            ]
        ], 400);
    }
}
