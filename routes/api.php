<?php


use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
//// Auth
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


});
