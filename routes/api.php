<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\InterestController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::group([
    'prefix' => 'v1'
], function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('getRoles', [RoleController::class, 'getRoles']);
        Route::get('permission', [RoleController::class, 'indexPermission']);

        Route::apiResources([
            'roles' => RoleController::class,
            'users' => UserController::class,
            'departments' => DepartmentController::class,
            'clients' => ClientController::class,
            'interests' => InterestController::class,
        ]);
    });
});
