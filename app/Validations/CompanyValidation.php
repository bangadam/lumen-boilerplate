<?php

namespace App\Validations;
use Illuminate\Support\Facades\Validator;
use App\Utils\Messages\ValidateMessage;

class CompanyValidation
{
    public function createCompany($request) :void{ 
        $messages = [
            'name.required' => 'Nama Wajib Diisi',
            'email.email'   => 'Format Email Tidak Sesuai'
        ];

        $validateConfig = Validator::make(
            (array)$request, 
            [
                'name'  => 'required',
                'email' => 'nullable|email'
            ],
            $messages
        )->validate();
    }

    public function updateCompany($request) : void{
        $messages = [
            'email.email'   => 'Format Email Tidak Sesuai'
        ];

        $validateConfig = Validator::make(
            (array)$request, 
            [
                'email' => 'nullable|email'
            ],
            $messages
        )->validate();
    }
}
