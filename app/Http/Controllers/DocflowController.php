<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocflowRequest;
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
    function list() 
    {
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

    //Удалить документооборот
    function deleteDocflow($docflowId)
    {
        return $this->service->deleteDocflowId($docflowId);
    }

    function insertDocflow(Request $request)
    {
        $cadastralNumber = $request->input('cadastralNumber');
        $this->service->insertDocflow($cadastralNumber);
        return back();
    }
}
