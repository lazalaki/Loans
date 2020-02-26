<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function store() {
        $token = auth()->attempt(request(['email', 'password']));
        if(!$token) {
            return response()->json([
                'message' => 'Podaci nisu validni'
            ], 400);
        } else {
            if(auth()->user()->is_active) {
                return response()->json([
                'message' => 'Uspesno ste se ulogoval',
                ]);
            } else {                
                
                return response()->json([
                    'message' => 'Please confirm your email verification'
                ]);
            }
            
        }        
        
    }


    public function verification($id) {

        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->token = null;
        $user->save();
    }
}
