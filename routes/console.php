<?php

use App\Console\Commands\DispatchNotifyCustomerWithMaxPoints;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('notify:customers-max-points', function () {
    $this->call(DispatchNotifyCustomerWithMaxPoints::class);
})->purpose('Notify customers who have enough points to redeem the maximum reward.')->schedule()->daily('');