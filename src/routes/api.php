<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\User\{UserController, UserEmailController};
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
Route::get('', function () {
    return response()->json('API ON!!!');
});

Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LogoutController::class, 'logout']);

### Users routes
Route::group(['prefix' => 'user'], function () {
    Route::post('', [UserController::class, 'store']);

    Route::group(['prefix' => '{user}'], function () {
        Route::post('set-image-profile', [UserController::class, 'setImageProfile']);
        Route::post('change-name', [UserController::class, 'changeName']);
        Route::post('request-change-email', [UserEmailController::class, 'requestChangeEmail']);
        Route::post('change-email', [UserEmailController::class, 'changeEmail']);
        Route::post('add-address', [AddressController::class, 'store']);
    });

    Route::group(['prefix' => 'address'], function () {
        Route::group(['prefix' =>'{address}'], function() {
            Route::patch('update', [AddressController::class, 'update']);
            Route::delete('delete', [AddressController::class, 'delete']);
        }) ;
    });

    Route::group(['prefix' => 'cart-item'], function () {
        Route::post('{item}', [CartItemController::class, 'store']);

        Route::group(['prefix' => '{cart_item}'], function () {
            Route::patch('', [CartItemController::class, 'update']);
            Route::delete('', [CartItemController::class, 'destroy']);
        });
    });

});

### Items Routes
Route::group(['prefix' => 'item'], function () {
    Route::post('', [ItemController::class, 'store']);
    Route::group(['prefix' => '{item}'], function () {
        Route::patch('', [ItemController::class, 'update']);
        Route::delete('', [ItemController::class, 'delete']);
    });
});
