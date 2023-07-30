<?php

use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/' . env('TELEGRAM_BOT_TOKEN') . '/webhook', [WebhookController::class, 'handle']);
