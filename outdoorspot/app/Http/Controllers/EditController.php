<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;



class EditController extends Controller {

    public function ajaxRequest()

    {

        return view('ajaxRequest');

    }

    public function ajaxRequestPost($request)

    {



        $request()->tilte;

        return response()->json(['success'=>'Got Simple Ajax Request.']);

    }


}