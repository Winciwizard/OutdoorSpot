<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function postUserCreate(Request $request)
    {
            $this->validate($request, [
               'email' => 'required|email|unique:users|max:255',
               'pseudo' => 'required|max:255',
               'password' => 'required|min:8|max: 32'
            ]);


            $email = $request->input('email');
            $pseudo = $request->input('pseudo');
            $password = bcrypt($request->input('password'));

            $user = new User();
            $user->setAttribute('email', $email);
            $user->setAttribute('pseudo', $pseudo);
            $user->setAttribute('password', $password);

            $user->save();

            Auth::login($user);

            return redirect()->route('dashboard');
    }
}
