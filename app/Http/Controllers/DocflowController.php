<?php

namespace App\Http\Controllers;

use App\Models\Docflow;
use Illuminate\Http\Request;

class DocflowController extends Controller
{
    function list() {
        $allDocflows = Docflow::all();
        return $allDocflows;
    }
}
