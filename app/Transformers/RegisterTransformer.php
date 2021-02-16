<?php
namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class RegisterTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

	public function transform(User $u)
	{
	    return [
            'id'     => (int) $u->id,
            'email'  => $u->email,
            'status' => $u->status
	    ];
    }

}
