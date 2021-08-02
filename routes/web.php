<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;



    /* Файлы */
Route::get('/', [MainController::class, 'tableOnPage']);
Route::get('/list', [MainController::class, 'list']);
Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
Route::patch('/{attachment}', [MainController::class, 'update']);
Route::delete('/{attachment}', [MainController::class, 'delete']);