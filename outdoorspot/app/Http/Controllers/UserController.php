<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class UserController extends Controller

{
    public function getInscription()
    {

        return view('/Inscription/inscription');
    }

    public function postSignUp (Request $request)
    {
        $this->validate($request,[
            'email'  => 'email|unique:users',
            'name' => 'required|max:70',
            'password'=> 'required|min:4'

        ]);


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

    public function postSignIn (Request $request)
    {
        $this->validate($request,[
            'email'  => 'email',
            'password'=> 'required'

        ]);

        if ( Auth::attempt(['email'=>$request['email'], 'password'=>$request['password']])) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    public function getDisconnect ()
    {
        Auth::logout();
        return redirect()->route('inscription');
    }



}