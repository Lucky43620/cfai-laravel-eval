<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class UserOrderController extends ApiController
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return $this->successResponse(OrderResource::collection($orders));
    }

    public function show(Request $request, $orderId)
    {
        $order = $request->user()
            ->orders()
            ->with(['items.product'])
            ->findOrFail($orderId);

        return $this->successResponse(new OrderResource($order));
    }
} 