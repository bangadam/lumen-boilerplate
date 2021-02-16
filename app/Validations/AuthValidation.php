<?php

namespace App\Validations;
use Illuminate\Support\Facades\Validator;
use App\Utils\Messages\ValidateMessage;

class AuthValidation
{
    public function doLogin($request) :void{ 
        $messages = [
            'email.required'    => 'Email Wajib Diisi',
            'email.email'       => 'Format Email Tidak Sesuai',
            'password.required' => 'Password Wajib Diisi'
        ];

        $validateConfig = Validator::make(
            (array)$request, 
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            $messages
        )->validate();
    }

    public function doRegister($request) : void{
        $messages = [
            'email.required'    => 'Email Wajib Diisi',
            'email.email'       => 'Format Email Tidak Sesuai',
            'password.required' => 'Password Wajib Diisi',
            'password.min'      => 'Password Terlalu Pendek'
        ];

        $validateConfig = Validator::make(
            (array)$request, 
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ],
            $messages
        )->validate();
    }
}
