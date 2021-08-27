<?php

namespace App\Http\Controllers;

use App\Models\Docflow;
use App\Services\KonturService;
use Illuminate\Http\Request;

class DocflowController extends Controller
{
    private KonturService $service;
    function __construct()
    {
        $this->service = new KonturService();
    }
    function list() {
        $allDocflows = Docflow::all();
        return view('docflows.list',[
            'docflows' => $allDocflows
        ]);
    }

    //Список таблицы
    function listJson() 
    {
        return Docflow::all();
    }

    //Обновить состояние документооборота
    function refreshDocflow($docflowId) 
    {
        return $this->service->refreshDocflowState($docflowId);
    }

    //Создать документооборот
    function createDocflow()
    {
        $this->service->createDocflow();
        return back();
    }

    //Удалить документооборот
    function deleteDocflow($docflowId)
    {
        return $this->service->deleteDocflowId($docflowId);
    }

}
