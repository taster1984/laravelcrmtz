<?php

use App\Http\Controllers\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/feedback-widget', [WidgetController::class, 'show']);
