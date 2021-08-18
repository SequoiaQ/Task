<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Log;


    /* Файлы */
Route::get('/', [MainController::class, 'tableOnPage']);
Route::get('/list', [MainController::class, 'list']);
Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
Route::patch('/{attachment}', [MainController::class, 'update']);
Route::delete('/{attachment}', [MainController::class, 'delete']);
Route::post('/send/{attachment}', [MainController::class, 'sendToKontur']);


    /* Логи*/

Route::middleware(['log.route'])->group(function () {
    Route::patch('/{attachment}', [MainController::class, 'update']);
    Route::delete('/{attachment}', [MainController::class, 'delete']);
    Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
});


    /*Запросы*/

Route::get('/guzzle', [MainController::class, 'guzzleMethod']);