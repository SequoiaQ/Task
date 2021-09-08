<?php

use App\Http\Controllers\DocflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Services\KonturService;
use Illuminate\Support\Facades\Log;


/*
    Файлы
*/

//Файлы из БД
Route::get('/', [MainController::class, 'tableOnPage']); 

//Данные в таблице
Route::get('/list', [MainController::class, 'list']);

//Загрузка файла
Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');

//Кнопка изменения
Route::patch('/{attachment}', [MainController::class, 'update']);

//Кнопка удаления
Route::delete('/{attachment}', [MainController::class, 'delete']);

//Загрузка на площадку
Route::post('/send/{attachment}', [MainController::class, 'sendToKontur']);


/*
    Логи
*/
Route::middleware(['log.route'])->group(function () {

    //Логи нажатия кнопки изменений
    Route::patch('/{attachment}', [MainController::class, 'update']);

    //Логи нажатия кнопки удаления
    Route::delete('/{attachment}', [MainController::class, 'delete']);

    //Логи нажатия кнопки загрузки
    Route::post('/upload-file', [MainController::class, 'fileUpload'])->name('fileUpload');
});


/*
    Запросы
*/

//Создание документооборота
Route::get('/doclflowCreate', [DocflowController::class, 'createDocflow'])->name('createDocflow');


//Страница с документооборотом              
Route::get('/docflows', [DocflowController::class, 'list']);  

//Удаление документооборота
Route::delete('/docflows/{docflowId}', [DocflowController::class, 'deleteDocflow']);

//Получение определенного документооборота
Route::get('/docflowid', [KonturService::class, 'getContentId']);

//Документообороты из таблицы                      
Route::get('/docflowsJson', [DocflowController::class, 'listJson']);

//Обновление статуса
Route::get('/refreshDocflow/{docflowId}', [DocflowController::class, 'refreshDocflow']);