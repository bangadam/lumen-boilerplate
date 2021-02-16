<?php

namespace App\Repositories\Auth;

interface IAuthRepository
{
    public function doLogin($request, $attr);
    public function doRegister($request);
    public function validateRegister($request);
}
