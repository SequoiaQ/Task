<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{

    public function loginPage() {
        return view("auth.login");
    }

    public function fetchingTable(){
        $attachment = Attachment::all();
        return response()->json([
            'attachment' => $attachment,
        ]);
    }

    /*<td>{{$row['+item.id+']}}</td>\
    <td>{{$row['+item.filename+']}}</td>\
    <td>{{$row['+item.local_path+']}}</td>\   */

    public function tableOnPage(){
      $attachment = Attachment::all()->toArray();
      return view('auth.login', compact('attachment'));

    } 

    public function fileUpload(Request $req){
        $formData = $req->validate([
            'name' => 'required',

        ]);
        $attachment = new Attachment();

        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

        $attachment->filename = $formData['name'];
        $attachment->url = Storage::url($filePath);
        $attachment->local_path = $filePath;
        $attachment->save();

        return "файл успешно отправлен";
   }
}

