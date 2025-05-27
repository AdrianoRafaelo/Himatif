<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KeuanganApiController;
use App\Http\Controllers\AdminMahasiswaController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('keuangan')->group(function () {
    Route::get('/', [KeuanganApiController::class, 'index']);
    Route::get('/{id}', [KeuanganApiController::class, 'show']);
    Route::post('/', [KeuanganApiController::class, 'store']);
    Route::put('/{id}', [KeuanganApiController::class, 'update']);
    Route::delete('/{id}', [KeuanganApiController::class, 'destroy']);
});

Route::get('/payments', [AdminMahasiswaController::class, 'getPayments']);