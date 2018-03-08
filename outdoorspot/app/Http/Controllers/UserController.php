<?php

namespace App\Http\Controllers;

use App\User;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller

{
    public function getInscription()
    {

        return view('/Inscription/inscription');
    }

    public function postSignUp (UserRequest $request)
    {

        $email = $request['email'];
        $name = $request['name'];
        $password = bcrypt( $request['password']);

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;

        $user->save();

        Auth::login($user);

        return redirect()->route('home');


    }



}