<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\RewardController;
use App\Http\Controllers\Api\V1\RedemptionController;
use App\Http\Controllers\Api\V1\PointController;
use App\Http\Controllers\Api\V1\PurchaseController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('customers', [CustomerController::class, 'store'])->middleware('check.permissions:001');
    Route::get('customers/{identifier}', [CustomerController::class, 'show'])->middleware('check.permissions:002');
    Route::get('customers', [CustomerController::class, 'index'])->middleware('check.permissions:003');
    Route::get('customers/{id}/rewards-status', [CustomerController::class, 'getCustomerRewardsStatus'])->middleware('check.permissions:004');
    Route::post('customers/{id}/points', [PointController::class, 'store'])->middleware('check.permissions:005');
    Route::post('customers/{id}/rewards/{rewardId}/redeem', [RewardController::class, 'redeem'])->middleware('check.permissions:006');
});
