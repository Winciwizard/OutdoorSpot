<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function postUserUpdate(Request $request)
    {
        //TODO: Validate du formulaire
       $user = Auth::user();
       if(isset($request->pseudo))
       {
           $user->setAttribute('pseudo',$request->input('pseudo'));
       }
       if(isset($request->nom))
       {
           $user->setAttribute('nom',$request->input('nom'));
       }
       if(isset($request->prenom))
       {
           $user->setAttribute('prenom',$request->input('prenom'));
       }
       if(isset($request->prenom))
       {
           $user->setAttribute('description',$request->input('description'));
       }

       $file = $request->file('image');
       if($file)
       {

           $cover = 'profil/'.md5(uniqid()).'.jpg';
           $user->setAttribute('user_image', $cover);
           Storage::disk('local')->put('public/'.$cover, File::get($file));
       }

       //TODO: Gerer la modification de password

       $user->update();


        return redirect()->route('dashboard');
    }

    public function getParameter()
    {
        return view('user/parameter', ['user' => Auth::user()]);
    }

    public function postUserConnect(Request $request)
    {
        $this->validate($request, [
            'pseudo-connect' => 'required',
            'password-connect' => 'required',
        ]);



        if (Auth::attempt(['pseudo' => $request['pseudo-connect'],
            'password' => $request['password-connect']]))
            {
                return redirect()->route('dashboard');
            }

        return redirect()->back();
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
