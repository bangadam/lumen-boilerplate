<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\V1\Controller;
use Illuminate\Http\Request;
use App\Repositories\Auth\IAuthRepository;
use App\Transformers\LoginTransformer;
use App\Transformers\RegisterTransformer;
use App\Validations\AuthValidation;

class AuthController extends Controller
{
    protected $authRepo;
    protected $authVal;

    public function __construct(
        IAuthRepository $authRepo,
        AuthValidation $authVal
    ) {
        $this->authRepo = $authRepo;
        $this->authVal = $authVal;
    }

    public function doLogin(Request $request)
    {
        $attr = $this->resolveRequest($request);
        $this->authVal->doLogin($attr);
        $login =  $this->authRepo->doLogin($request, $attr);
        return $this->singleResponse(
            $request,
            $login,
            'logins',
            new LoginTransformer()
        );
    }

    public function doRegister(Request $request)
    {
        $attr = $this->resolveRequest($request);
        $this->authVal->doRegister($attr);
        $user =  $this->authRepo->doRegister($attr);
        return $this->singleResponse(
            $request,
            $user,
            'registers',
            new RegisterTransformer()
        );
    }

    public function validateRegister(Request $request)
    {
        $user =  $this->authRepo->validateRegister($request);

        if ($user == null) {
            return $this->emptyResponse('Validasi User Baru Gagal, Data Tidak Valid');
        }

        return $this->singleResponse(
            $request,
            $user,
            'registers-validate',
            new RegisterTransformer()
        );
    }
}
