<?php

use App\Http\Controllers\Admin\RecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('admin')->group(function () {
    Route::controller(RecordController::class)->group(function () {
        Route::prefix('records')->group(function () {
            Route::get('/', 'records')->name('admin.records');
            Route::post('/', 'create')->name('admin.records.create');
        });
    });


});
