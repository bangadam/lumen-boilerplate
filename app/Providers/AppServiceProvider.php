<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Company\ICompanyRepository',
            'App\Repositories\Company\CompanyRepository'
        );

        $this->app->bind(
            'App\Repositories\Employee\IEmployeeRepository',
            'App\Repositories\Employee\EmployeeRepository'
        );

        $this->app->bind(
            'App\Repositories\Auth\IAuthRepository',
            'App\Repositories\Auth\AuthRepository'
        );        
    }
}
