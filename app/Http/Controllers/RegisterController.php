<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function __construct() {
        $this->middleware('guest');
    }

    public function store(RegisterRequest $request) {       
        
        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'token' => Str::random(20)           
        ]);

        try{
        $user->save();
    } catch(Exception $exception) {
        return response()->json(['Email is already taken'], 400);
    }

        Mail::to($request->email)->send(new SendMailable($user));

        
    }
}
