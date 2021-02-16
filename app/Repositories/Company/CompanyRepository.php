<?php

namespace App\Repositories\Company;

use App\Repositories\Company\ICompanyRepository;
use App\Models\Company;
use App\Constants\PaginatorConst;
use Illuminate\Pagination\Paginator;
use Auth;
use DB;
use App\Services\Keyword;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;

class CompanyRepository implements ICompanyRepository
{
    public function getCompanies($request){
        $limit = $request->get('limit', PaginatorConst::$Size);
		$page = $request->get('page', PaginatorConst::$Page);
		Paginator::currentPageResolver(function() use ($page) {
			return $page;
        });
        $defaults = new Company;
        $defaults = Keyword::search($defaults, $request);
        $defaults = Keyword::order($defaults,$request);
        $companies = $defaults->paginate($limit);
        return $companies;
    }

    public function getCompanyById($id){
        $company = Company::find($id);
        return $company;
    }

    public function createCompany($request){
        $transac = DB::transaction(function() use($request){
            $company = new Company;
            $company->name      = $request->name;
            $company->email     = isset($request->email) ? $request->email : null;
            $company->logo      = isset($request->logo) ? \App\Services\File::decryptImage($request->logo,'logo') : null;
            $company->website   = isset($request->website) ? $request->website : null; 
            $company->save();
            return compact('company');
        });
        return $transac['company'];
    }

    public function updateCompany($request,$id){
        $transac = DB::transaction(function() use($request,$id){
            $company = Company::find($id);
            if($company == null){
                return compact('company');
            }

            $company->name  = isset($request->name) ? $request->name : $company->name;
            $company->email = isset($request->email) ? $request->email : $company->email;
            $company->logo  = isset($request->logo) ? \App\Services\File::decryptImage($request->logo,'logo') : $company->logo;
            $company->website = isset($request->website) ? $request->website : $company->website;
            $company->save();
            
            return compact('company');
        });
        return $transac['company'];
    }

    public function deleteCompany($id){
        $company = Company::find($id);
        if($company == null){
            return false;
        }
        $company->delete();
        return true;
    }
}

