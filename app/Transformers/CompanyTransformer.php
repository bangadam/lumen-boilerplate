<?php
namespace App\Transformers;

use App\Models\Company;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];

	public function transform(Company $c)
	{
	    return [
            'id'            => (int) $c->id,
            'name'          => $c->name,
            'email'         => $c->email,
            'logo'          => $c->logo != null ? env('APP_URL').'/api/v1/files/' . $c->logo : null,
            'website'       => $c->website,
            'dateCreated'   => $c->dateCreated,
            'dateUpdated'   => $c->dateUpdated,
            'dateDeleted'   => $c->dateDeleted
	    ];
    }

}
