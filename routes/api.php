<?php

use App\Http\Controllers\CashMouvementController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Models\CashRegister;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\LogoutResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // DEFINE CUSTOM ROUTES
    Route::group([
        'prefix' => 'dashboard',
        'name' => 'dashboard.',
    ], function () {
        Route::group([
            'prefix' => 'ca',
            'name' => 'ca.',
        ], function () {
            Route::get('gross', [DashboardController::class, 'ca_gross'])->name('gross');
            Route::get('net', [DashboardController::class, 'ca_net'])->name('net');
            Route::get('paymentmethods', [DashboardController::class, 'ca_by_payment_methods'])->name('paymentmethods');
            Route::get('off', [DashboardController::class, 'ca_off'])->name('off');
        });
        Route::group([
            'prefix' => 'tickets',
            'name' => 'tickets.',
        ], function () {
            Route::get('total', [DashboardController::class, 'nb_tickets'])->name('total');
            Route::get('paymentmethods', [DashboardController::class, 'nb_tickets_by_payment_methods'])->name('paymentmethods');
            Route::get('types', [DashboardController::class, 'nb_tickets_by_order_types'])->name('types');
        });
        Route::group([
            'prefix' => 'total',
            'name' => 'total.',
        ], function () {
            Route::get('estimated', [DashboardController::class, 'total'])->name('estimated');
            Route::get('reel', [DashboardController::class, 'total_reel'])->name('reel');
        });
        Route::get('tip', [DashboardController::class, 'tip']);
    });
    // TODO: create AuthenticatedSessionController controller to override the used package
    Route::post('logout', function (Request $request, StatefulGuard $guard) {
        $total_gain = Auth::user()
            ->cash_registers()
            ->where('register_type', 'out')
            ->get()
            ->sum(function (CashRegister $cashRegister) {
                return collect($cashRegister->cash_units)->reduce(function (?int $carry, int $value, string $key) {
                    return $carry + ($value * floatval(config('cash_units.' . $key)));
                });
            });
        -
            Auth::user()
            ->cash_registers()
            ->where('register_type', 'in')
            ->get()
            ->sum(function (CashRegister $cashRegister) {
                return collect($cashRegister->cash_units)->reduce(function (?int $carry, int $value, string $key) {
                    return $carry + ($value * floatval(config('cash_units.' . $key)));
                });
            });
        $request->merge([
            'total_gain' => $total_gain,
        ]);
        $guard->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return app(LogoutResponse::class);
    });
    Route::post('menus/{menu}', [MenuController::class, 'update'])->name('menus.update.upload');
    Route::post('cashMouvements/{cashMouvement}', [CashMouvementController::class, 'update'])->name('cashMouvements.update..upload');
    // DEFINE RESOURCES CONTROLLERS
    Route::resources([
        'clients' => ClientController::class,
        'users' => UserController::class,
        'menus' => MenuController::class,
        'items' => ItemController::class,
        'tables' => TableController::class,
        'orders' => OrderController::class,
        'cashMouvements' => CashMouvementController::class,
        'cashRegisters' => CashRegisterController::class,
        'settings' => SettingController::class,
        'roles' => RoleController::class,
    ]);
    // TESTING ROUTES
    Route::get('postman-user', fn(Request $request) => $request->user()->load('roles'));
});
