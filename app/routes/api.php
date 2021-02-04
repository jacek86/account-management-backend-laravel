<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('ping', [SiteController::class, 'index']);
Route::post('amount', [TransactionController::class, 'create'])->middleware('validate.contenttype');;
Route::get('transaction/{id}', [TransactionController::class, 'view']);
Route::get('balance/{id}', [AccountController::class, 'view']);
Route::get('max_transaction_volume', [AccountController::class, 'getMaxTransactions']);