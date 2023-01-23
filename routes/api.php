<?php


use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
//// Authentication
], function ($router) {
    Route::controller(AuthController::class)->prefix('auth/')->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('me', 'me');
    });


    ////Employee
    Route::apiResource('/employee' , EmployeeController::class);

   ////Supplier
    Route::apiResource('/supplier' , SupplierController::class);

    ////Category
    Route::apiResource('/category' , CategoryController::class);

    ////Product
    Route::apiResource('/product' , ProductController::class);
});
