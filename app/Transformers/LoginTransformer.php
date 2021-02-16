<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class LoginTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

	public function transform(array $l)
	{
        $user    = $l['user'];
        $token   = $l['token'];
        $expired = $l['expired'];

	    return [
            'id'            => (int) $user->id,
            'email'         => $user->email,
            'status'        => $user->status,
            'accessToken'   => $token,
            'expired'       => strtotime($expired)
	    ];
    }

}
