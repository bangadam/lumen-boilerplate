<?php

namespace App\Repositories\Employee;

interface IEmployeeRepository
{
    public function getEmployees($request);
    public function getEmployeeById($id);
    public function createEmployee($request);
    public function updateEmployee($request,$id);
    public function deleteEmployee($id);
}
