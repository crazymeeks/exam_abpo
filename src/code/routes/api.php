<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CustomerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::group(['namespace' => 'Api'], function($route){

    $route->post('/login', [LoginController::class, 'action'])->name('api.login');

    $route->group(['prefix' => 'customers', 'middleware' => ['api.auth']], function($route){
        $route->get('/', [CustomerController::class, 'get'])->name('api.customers.get');
        $route->post('/', [CustomerController::class, 'create'])->name('api.customers.create');
        $route->put('/{id}', [CustomerController::class, 'update'])->name('api.customers.update');
        $route->delete('/{id}', [CustomerController::class, 'delete'])->name('api.customers.delete');
        $route->get('/{id}', [CustomerController::class, 'find'])->name('api.customers.find');
    });
});