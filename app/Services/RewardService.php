<?php

namespace App\Services;

use App\Mail\RewardRedeemedMail;
use App\Models\Customer;
use App\Models\Reward;
use App\Models\Redemption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RewardService
{
    /**
     * Redeems a reward for a customer if they have enough points.
     *
     * @param int $customerId
     * @param int $rewardId
     * @return array
     */
    public function redeemReward(int $customerId, int $rewardId): array
    {
        return DB::transaction(function () use ($customerId, $rewardId) {
            $customer = Customer::findOrFail($customerId);
            $reward = $this->findReward($rewardId);

            if (!$this->hasSufficientPoints($customer, $reward->required_points)) {
                return $this->createResponse('Insufficient points to redeem this reward.', 400, 'failure');
            }

            $this->processRedemption($customer, $reward);

            return $this->createResponse('Reward successfully redeemed.', 200, 'success');
        });
    }

    /**
     * Processes the logic for redeeming the reward.
     *
     * @param Customer $customer
     * @param Reward $reward
     * @return void
     */
    protected function processRedemption(Customer $customer, Reward $reward): void
    {
        $this->createRedemption($customer, $reward);
        $this->deductCustomerPoints($customer, $reward->required_points);
        Mail::to($customer->email)->queue(new RewardRedeemedMail($customer, $reward));
    }

    /**
     * Creates a standardized response.
     *
     * @param string $message
     * @param int $statusCode
     * @param string $responseType
     * @return array
     */
    protected function createResponse(string $message, int $statusCode, string $responseType = 'success'): array
    {
        return [
            'message' => $message,
            'status_code' => $statusCode,
            'response' => $responseType
        ];
    }

    /**
     * Finds a reward by its ID.
     *
     * @param int $rewardId
     * @return Reward
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function findReward(int $rewardId): Reward
    {
        return Reward::findOrFail($rewardId);
    }

    /**
     * Checks if the customer has enough points for the reward.
     *
     * @param Customer $customer
     * @param int $requiredPoints
     * @return bool
     */
    private function hasSufficientPoints(Customer $customer, int $requiredPoints): bool
    {
        $currentPoints = $customer->points()->first();
        return $currentPoints && $currentPoints->points >= $requiredPoints;
    }

    /**
     * Creates a reward redemption.
     *
     * @param Customer $customer
     * @param Reward $reward
     */
    private function createRedemption(Customer $customer, Reward $reward): void
    {
        Redemption::create([
            'customer_id' => $customer->id,
            'reward_id' => $reward->id,
        ]);
    }

    /**
     * Deducts points from the customer.
     *
     * @param Customer $customer
     * @param int $pointsToDeduct
     */
    private function deductCustomerPoints(Customer $customer, int $pointsToDeduct): void
    {
        $currentPoints = $customer->points()->first();

        if ($currentPoints) {
            $currentPoints->points -= $pointsToDeduct;
            $currentPoints->save();
        }
    }
}
