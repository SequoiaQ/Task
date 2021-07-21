<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{

    public function loginPage() {
        return view("auth.login");
    }


    public function register(Request $request){
        $all = $request->validate([
            'name' => 'required|between:5,10',
            'email' => 'required|email',
            'pass' => 'required',
            'pwag' => 'required|same:pass'
        ]);
        $formData = $request->all();
        $user = new User();
        $user->login = $formData['name'];
        $user->pass = $formData['pass'];
        $user->save();

        return "Пользователь сохранен успешно!";
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

