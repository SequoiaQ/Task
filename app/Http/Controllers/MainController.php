<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $accounts = [
        [
            "login"=>"user1",
            "password"=>"password"
        ],
        [
            "login"=>"user2",
            "password"=>"password"
        ],
        [
            "login"=>"user3",
            "password"=>"password"
        ],
    ];  

    private function auth(string $login, string $password){
        foreach ($this->accounts as $accItem) {
            if (
                $accItem['login'] == $login &&
                $accItem['password'] == $password
            ) {
                return true;
            }
        }
        return false;
    }
    public function loginPage() {
        return view("auth.login");
    }
    public function register(Request $request){
        $all = $request->validate([
            'login' => 'required|between:5,10',
            'email' => 'required|email',
            'pass' => 'required',
            'pwag' => 'required|same:pass'
        ]);
        if ($this->auth($all['login'], $all['pass'])) {
            return "Вы авторизованы";
        }
        return "Вы не авторизованы";
    }
}