<?php

namespace App\Http\Controllers\V1\Employee;

use App\Http\Controllers\V1\Controller;
use Illuminate\Http\Request;
use App\Repositories\Employee\IEmployeeRepository;
use App\Models\Employee;
use App\Transformers\EmployeeTransformer;
use App\Validations\EmployeeValidation;
use Illuminate\Auth\Access\AuthorizationException;

class EmployeeController extends Controller
{
    protected $employeeRepo;
    protected $employeeVal;

    public function __construct(
        IEmployeeRepository $employeeRepo,
        EmployeeValidation $employeeVal
    )
    {
        $this->employeeRepo = $employeeRepo;
        $this->employeeVal = $employeeVal;
    }
    
    public function index(Request $request)
    {
        $paginator =  $this->employeeRepo->getEmployees($request);
        return $this->paginateResponse(
            $request,
            $paginator, Employee::$Type,
            new EmployeeTransformer()
        );
    }

    public function store(Request $request)
    {
        $attr = $this->resolveRequest($request);
        $this->employeeVal->createEmployee($attr);
        $employee = $this->employeeRepo->createEmployee($attr);
        
        return $this->crateUpdateResponse(
            $request,
            $employee,
            Employee::$Type,
            new EmployeeTransformer()
        );
    }

    public function update(Request $request, $id)
    {
        $attr = $this->resolveRequest($request);
        $this->employeeVal->updateEmployee($attr);
        $employee = $this->employeeRepo->updateEmployee($attr,$id);

        if($employee == null){
            throw new AuthorizationException("Anda Tidak Diperbolehkan Mengakses Endpoint");
        }
        
        return $this->crateUpdateResponse(
            $request,
            $employee,
            Employee::$Type,
            new EmployeeTransformer()
        );
    }

    public function show(Request $request, $id)
    {
        $employee = $this->employeeRepo->getEmployeeById($id);
        
        if($employee != null){
            return $this->singleResponse(
                $request,
                $employee,
                Employee::$Type,
                new EmployeeTransformer()
            );
        }

        return $this->emptyResponse("Data Tidak Ada");
    }

    public function destroy(Request $request, $id)
    {
        $employee = $this->employeeRepo->deleteEmployee($id);
        if(!$employee){
            throw new AuthorizationException("Anda Tidak Diperbolehkan Mengakses Endpoint");
        }
        return $this->deleteResponse();
    }
}
