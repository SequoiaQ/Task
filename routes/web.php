<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/',[MainController::class, 'loginPage'] );
Route::post('/register',[MainController::class, 'register'] );