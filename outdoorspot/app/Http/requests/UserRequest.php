<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {

        return [

            'email'  => 'email|unique:users',
            'name' => 'required|max:70',
            'password'=> 'required|min:4'

        ];
    }
}