<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointRequest;
use App\Services\PointService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PointController extends Controller
{
    protected $pointService;

    public function __construct(PointService $pointService)
    {
        $this->pointService = $pointService;
    }

    /**
     * Adds points to a customer based on the amount spent.
     *
     * @param int $id
     * @param PointRequest $request
     * @return JsonResponse
     */
    public function store(int $customerId, PointRequest $request): JsonResponse
    {
        $result = $this->pointService->processPoints($customerId, $request->input('spent_value'));

        return $this->successResponse($result, 200);
    }
}
