<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\LoginController;

Route::get('/', [LoginController::class, 'index']);


Route::group(['prefix' => 'customers'], function($route){

    $route->get('/', function(){
        return view('listing');
    });

    $route->get('/new', function(){
        return view('create');
    });
    
    $route->get('/{id}/edit', function(){
        return view('edit');
    });
});