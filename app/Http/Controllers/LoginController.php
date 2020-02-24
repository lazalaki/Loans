<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function verification($id) {

        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->token = null;
        $user->save();
    }
}
