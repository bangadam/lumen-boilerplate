<?php

namespace App\Repositories\Employee;

use App\Repositories\Employee\IEmployeeRepository;
use App\Models\Employee;
use App\Models\Company;
use App\Constants\PaginatorConst;
use Illuminate\Pagination\Paginator;
use Auth;
use DB;
use App\Services\Keyword;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class EmployeeRepository implements IEmployeeRepository
{
    public function getEmployees($request){
        $limit = $request->get('limit', PaginatorConst::$Size);
		$page = $request->get('page', PaginatorConst::$Page);
		Paginator::currentPageResolver(function() use ($page) {
			return $page;
        });
        $defaults = new Employee;
        $defaults = Keyword::search($defaults, $request);
        $defaults = Keyword::order($defaults,$request);
        $employees = $defaults->paginate($limit);
        return $employees;
    }

    public function getEmployeeById($id){
        $employee = Employee::find($id);
        return $employee;
    }

    public function createEmployee($request){
        $transac = DB::transaction(function() use($request){
            $company = Company::find($request->companyId);
            if($company == null){
                DB::rollBack();
                throw ValidationException::withMessages([
                    'companyId' => 'ID Tidak Valid'
                ]);
            }

            $employee = new Employee;
            $employee->company_id   = $company->id;
            $employee->firstName    = $request->firstName;
            $employee->lastName     = $request->lastName;
            $employee->email        = isset($request->email) ? $request->email : null;
            $employee->phone        = isset($request->phone) ? $request->phone : null; 
            $employee->save();
            return compact('employee');
        });
        return $transac['employee'];
    }

    public function updateEmployee($request,$id){
        $transac = DB::transaction(function() use($request,$id){
            if(isset($request->companyId) && $request->companyId != null){
                $company = Company::find($request->companyId);
                if($company == null){
                    DB::rollBack();
                    throw ValidationException::withMessages([
                        'companyId' => 'ID Tidak Valid'
                    ]);
                }
            }

            $employee = Employee::find($id);
            if($employee == null){
                DB::rollBack();
                throw ValidationException::withMessages([
                    'employee' => 'Data Tidak Ada'
                ]);
            }

            $employee->company_id   = isset($request->companyId) ? $request->companyId : $employee->company_id;
            $employee->firstName    = isset($request->firstName) ? $request->firstName : $employee->firstName;
            $employee->lastName     = isset($request->lastName) ? $request->lastName : $employee->lastName;
            $employee->email        = isset($request->email) ? $request->email : $employee->email;
            $employee->phone        = isset($request->phone) ? $request->phone : $employee->phone; 
            $employee->save();
            
            return compact('employee');
        });
        return $transac['employee'];
    }

    public function deleteEmployee($id){
        $employee = Employee::find($id);
        if($employee == null){
            return false;
        }
        $employee->delete();
        return true;
    }
}

