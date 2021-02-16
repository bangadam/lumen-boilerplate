<?php

namespace App\Repositories\Company;

interface ICompanyRepository
{
    public function getCompanies($request);
    public function getCompanyById($id);
    public function createCompany($request);
    public function updateCompany($request,$id);
    public function deleteCompany($id);
}
