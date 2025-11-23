<?php

use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\WidgetController;
use App\Http\Middleware\EnsureUserIsManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/feedback-widget', [WidgetController::class, 'show']);

Route::prefix('admin')->middleware(['auth', EnsureUserIsManager::class])->group(function () {
    Route::get('tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('admin.tickets.updateStatus');
});

Auth::routes([
    'register' => false,
    'reset' => false,
]);
