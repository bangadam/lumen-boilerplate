<?php
namespace App\Transformers;

use App\Models\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['company'];

	public function transform(Employee $emp)
	{
	    return [
            'id'            => (int) $emp->id,
            'companyId'     => $emp->company_id,
            'firstName'     => $emp->firstName,
            'lastName'      => $emp->lastName,
            'email'         => $emp->email,
            'phone'         => $emp->phone,
            'dateCreated'   => $emp->dateCreated,
            'dateUpdated'   => $emp->dateUpdated,
            'dateDeleted'   => $emp->dateDeleted
	    ];
    }

    public function includeCompany(Employee $emp){
        $company = $emp->company;
        if($company != null){
            return $this->item($company, new CompanyTransformer, 'company');
        }
    }

}
