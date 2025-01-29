<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;

class UserReviewController extends ApiController
{
    public function index(Request $request)
    {
        $reviews = $request->user()
            ->reviews()
            ->with(['product'])
            ->latest()
            ->paginate(10);

        return $this->successResponse(ReviewResource::collection($reviews));
    }

    public function show(Request $request, $reviewId)
    {
        $review = $request->user()
            ->reviews()
            ->with(['product'])
            ->findOrFail($reviewId);

        return $this->successResponse(new ReviewResource($review));
    }
} 