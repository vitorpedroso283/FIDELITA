<?php

namespace App\Services;

use App\Mail\PointsEarnedMail;
use App\Models\Customer;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PointService
{
    /**
     * Processes a purchase and updates the customer's points balance.
     *
     * @param int $customerId
     * @param float $spentValue
     * @return array
     */
    public function processPoints(int $customerId, float $spentValue): array
    {
        $points = $this->calculatePoints($spentValue);

        return DB::transaction(function () use ($customerId, $points, $spentValue) {
            $customer = Customer::findOrFail($customerId);
            $purchase = $this->createPurchase($customer, $spentValue, $points);
            $this->processCustomerPoints($customer, $points);

            return [
                'purchase' => $purchase,
                'current_points' => $customer->points()->first()->points ?? 0
            ];
        });
    }

    /**
     * Processes the customer's points and sends an email if they earn points.
     *
     * @param \App\Models\Customer $customer The customer who will receive the points.
     * @param int $points The amount of points to be assigned to the customer.
     */
    private function processCustomerPoints($customer, $points)
    {
        // Checks if the customer earned points (points greater than zero)
        if ($points > 0) {
            // Updates the customer's points in the system
            $this->updateCustomerPoints($customer, $points);

            // Sends an email to the customer informing them that they earned points
            Mail::to($customer->email)->queue(new PointsEarnedMail($customer, $points));
        }
    }

    /**
     * Calculates points based on the amount spent.
     *
     * @param float $spentValue
     * @return int
     */
    private function calculatePoints(float $spentValue): int
    {
        $minimumSpendForPoints = 5; // R$5.00
        $pointsPerUnit = 1; // 1 point for every R$5.00

        if ($spentValue < $minimumSpendForPoints) {
            return 0;
        }

        return intdiv($spentValue, $minimumSpendForPoints) * $pointsPerUnit;
    }

    /**
     * Creates a new purchase.
     *
     * @param Customer $customer
     * @param float $spentValue
     * @param int $points
     * @return Purchase
     */
    private function createPurchase(Customer $customer, float $spentValue, int $points): Purchase
    {
        return Purchase::create([
            'customer_id' => $customer->id,
            'spent_value' => $spentValue,
            'points' => $points,
        ]);
    }

    /**
     * Updates the customer's points balance.
     *
     * @param Customer $customer
     * @param int $points
     */
    private function updateCustomerPoints(Customer $customer, int $points): void
    {
        $currentPoints = $customer->points()->first();

        if ($currentPoints) {
            $currentPoints->points += $points;
            $currentPoints->save();
        } else {
            $customer->points()->create(['points' => $points]);
        }
    }
}
