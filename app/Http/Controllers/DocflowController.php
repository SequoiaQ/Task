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

    function listJson() {
        return Docflow::all();
    }

    function refreshDocflow($docflowId) {
        return $this->service->refreshDocflowState($docflowId);
    }

    function createDocflow() {
        return $this->service->createDocflow();
    }

    function docflowDownload(){
        // return $this->service->docflow
    }
}
