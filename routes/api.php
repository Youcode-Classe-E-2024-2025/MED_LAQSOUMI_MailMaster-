<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Api\CampaignController;
// use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\NewsletterController;
// use App\Http\Controllers\Api\SubscriberController;
use Illuminate\Support\Facades\Route;



// Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('newsletters', NewsletterController::class);
//     Route::apiResource('subscribers', SubscriberController::class);
//     Route::apiResource('campaigns', CampaignController::class)->except(['index', 'store']);
//     Route::post('/newsletters/{newsletter}/subscribers/{subscriber}', [ListController::class, 'addSubscriber'])
//         ->name('newsletters.subscribers.attach');
//     Route::delete('/newsletters/{newsletter}/subscribers/{subscriber}', [ListController::class, 'removeSubscriber'])
//         ->name('newsletters.subscribers.detach');
//     Route::get('/newsletters/{newsletter}/subscribers', [ListController::class, 'getSubscribers'])
//         ->name('newsletters.subscribers.index');
//     Route::get('/subscribers/{subscriber}/newsletters', [ListController::class, 'getNewslettersForSubscriber'])
//         ->name('subscribers.newsletters.index');
// });

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
