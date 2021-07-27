<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;


Route::get('/',[MainController::class, 'loginPage'] );
Route::post('/local', [MainController::class, 'storage']);
Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
Route::get('/', [MainController::class, 'tableOnPage']);
Route::get('/fetchingTable', [MainController::class, 'fetchingTable']);
