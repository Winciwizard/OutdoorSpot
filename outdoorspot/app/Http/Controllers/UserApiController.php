<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        return response()->json($user, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
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
            if(!(Hash::check($request->get('oldpass'), $user->password)))
            {
                return response()->json(['error' => 'Mauvais mot de passe actuel'], JsonResponse::HTTP_BAD_REQUEST);
            }

            $this->validate($request, ['password' => 'required|min:8']);
            /** Verification que le nouveau et l'ancien pass ne soit pas les même*/
            if(strcmp($request->get('oldpass'), $request->get('newpass')) == 0 )
            {
                return response()->json(['error' => 'Nouveau password identique à l\'ancien'], JsonResponse::HTTP_BAD_REQUEST);
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

        return response()->json($user, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        return "<h1>Y a que PAPA qui a le DROIT</h1>";
    }
}
