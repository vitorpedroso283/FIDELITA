<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\NotifyCustomerWithMaxPoints;
use App\Models\Customer;
use App\Models\Reward;

class DispatchNotifyCustomerWithMaxPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:customers-max-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies customers who have enough points to redeem the maximum reward.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reward = Reward::orderBy('required_points', 'desc')->first();
        if (!$reward) {
            $this->info('No reward found.');
            return Command::SUCCESS;
        }

        $maxPointsRequired = $reward->required_points;
        // Retrieve the emails of customers who have at least this amount of points
        $emails = Customer::whereHas('points', function ($query) use ($maxPointsRequired) {
            $query->where('points', '>=', $maxPointsRequired);
        })->pluck('email');

        // Dispatch the job for each customer with the reward
        foreach ($emails as $email) {
            $customer = Customer::where('email', $email)->first();
            if ($customer) {
                NotifyCustomerWithMaxPoints::dispatch($customer, $reward);
            }
        }

        $this->info('Notifications sent to customers with maximum points.');

        return Command::SUCCESS;
    }
}
