<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
    

            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

        return "файл успешно отправлен";
   }
}

