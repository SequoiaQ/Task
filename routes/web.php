<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('/',[MainController::class, 'loginPage'] );
Route::post('/register',[MainController::class, 'register']);
Route::post('/local', [MainController::class, 'storage']);
Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
