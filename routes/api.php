<?php

use App\Http\Controllers\CashMouvementController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    // DEFINE RESOURCES CONTROLLERS
    Route::resources([
        'clients' => ClientController::class,
        'menus' => MenuController::class,
        'items' => ItemController::class,
        'tables' => TableController::class,
        'orders' => OrderController::class,
        'cashMouvements' => CashMouvementController::class,
        'cashRegisters' => CashRegisterController::class,
    ]);
});
