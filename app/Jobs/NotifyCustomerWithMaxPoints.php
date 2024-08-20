<?php

namespace App\Jobs;

use App\Console\Commands\DispatchNotifyCustomerWithMaxPoints;
use App\Mail\MaxPointsRedeemableMail;
use App\Models\Customer;
use App\Models\Reward;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyCustomerWithMaxPoints implements ShouldQueue
{
    use Queueable;

    protected $customer;
    protected $reward;

    /**
     * Creates a new instance of the job.
     *
     * @param \App\Models\Customer $customer
     * @param \App\Models\Reward $reward
     */
    public function __construct(Customer $customer, Reward $reward)
    {
        $this->customer = $customer;
        $this->reward = $reward;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Sends the email to the customer
        Mail::to($this->customer->email)->send(new MaxPointsRedeemableMail($this->customer, $this->reward));
    }
}
