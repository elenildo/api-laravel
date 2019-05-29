<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function cadastro(Request $request){
        $user = $request->all();
        $user["password"] = bcrypt($user["password"]);
        User::create($user);
        return response()->json(['success'=> true]);
    }

    public function index(){
        return response()->json(["name" => Auth::user()->name]);
    }
}