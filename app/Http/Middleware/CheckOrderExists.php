<?php

namespace App\Http\Middleware;

use App\Repositories\OrderRepository;
use Closure;

class CheckOrderExists
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $orderId = $request->route('id');

        if (!OrderRepository::find($orderId)) {
            $responseData = [
                "message" => "The given data was invalid.",
                "errors" => [
                    "order_id" => [
                        "The order with id = {$orderId} does not exist."
                    ]
                ]
            ];
            return response()->json($responseData);
        }
        return $next($request);
    }
}
