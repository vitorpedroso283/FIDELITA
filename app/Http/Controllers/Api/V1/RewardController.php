<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\RewardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    protected $rewardService;

    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    /**
     * Redeems a reward for a customer.
     *
     * @param int $customerId
     * @param int $rewardId
     * @return JsonResponse
     */
    public function redeem(int $customerId, int $rewardId): JsonResponse
    {
        $result = $this->rewardService->redeemReward($customerId, $rewardId);

        return $this->successResponse([
            'message' => $result['message']
        ], $result['status_code'], $result['response']);
    }
}
