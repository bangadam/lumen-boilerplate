<?php

namespace App\Validations;
use Illuminate\Support\Facades\Validator;
use App\Utils\Messages\ValidateMessage;

class EmployeeValidation
{
    public function createEmployee($request) :void{ 
        $messages = [
            'companyId.required' => 'Wajib Diisi',
            'firstName.required' => 'Nama Depan Wajib Diisi',
            'lastName.required'  => 'Nama Belakang Wajib Diisi',
            'email.email'        => 'Format Email Tidak Sesuai'
        ];

        $validateConfig = Validator::make(
            (array)$request, 
            [
                'companyId' => 'required',
                'firstName' => 'required',
                'lastName'  => 'required',
                'email'     => 'nullable|email'
            ],
            $messages
        )->validate();
    }

    public function updateEmployee($request) : void{
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
