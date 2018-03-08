<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return Route
     */
    public function postUserCreate(Request $request): Route
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
        $user->setAttribute('user_image','profil/profil-default.jpg');

        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * @param Request $request
     * @return Route
     */
    public function postUserUpdate(Request $request)
    {
        $user = Auth::user();

        /** Verification de la presence de l'élèment à changer et l'integre à l'objet */
       if(isset($request->pseudo))
       {
           $this->validate($request, ['pseudo' => 'required|unique:users|max:255']);
           $user->setAttribute('pseudo',$request->input('pseudo'));
       }

       if(isset($request->nom))
       {
           $this->validate($request, ['nom' => 'required|max:255']);
           $user->setAttribute('nom',$request->input('nom'));
       }

       if(isset($request->prenom))
       {
           $this->validate($request, ['prenom' => 'required|max:255']);
           $user->setAttribute('prenom',$request->input('prenom'));
       }

       if(isset($request->description))
       {
           $this->validate($request, ['description' => 'required|max:255']);
           $user->setAttribute('description',$request->input('description'));
       }

       if(isset($request->oldpass) && isset($request->newpass) && isset($request->password))
       {
            /** Verification avec l'ancien password */
            if(!(Hash::check($request->get('oldpass'), Auth::user()->password)))
            {
                return redirect()->back();
            }

            $this->validate($request, ['password' => 'required|min:8']);
            /** Verification que le nouveau et l'ancien pass ne soit pas les même*/
            if(strcmp($request->get('oldpass'), $request->get('newpass')) == 0 )
            {
                return redirect()->back();
            }

            $user->password = bcrypt($request->get('password'));

       }

        /** Récupére le fichier */
        $file = $request->file('image');

        /** Si il y a un fichier, il enregistre et change le nomn dans la BDD */
       if($file)
       {
           $this->validate($request, ['image' => 'required|mimes:jpg,jpeg']);
           $cover = 'profil/'.md5(uniqid()).'.jpg';
           $user->setAttribute('user_image', $cover);
           Storage::disk('local')->put('public/'.$cover, File::get($file));
       }

       /** MAJ de la base de donnée */
       $user->update();

       return redirect()->route('dashboard');
    }


    /**
     * @return View
     */
    public function getParameter(): View
    {
        return view('user/parameter', ['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUserConnect(Request $request)
    {
        $this->validate($request, [
            'pseudo-connect' => 'required',
            'password-connect' => 'required',
        ]);

        /** Verificaiton pseudo et password */
        if (Auth::attempt(['pseudo' => $request['pseudo-connect'],
            'password' => $request['password-connect']]))
            {
                return redirect()->route('dashboard');
            }

        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
