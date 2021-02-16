<?php

$router->get('/signature', function () use ($router) {
    return response(array('api' => env('APP_NAME').' V1'), 200)
        ->header('Content-Type', 'application/json');
});

$router->group(['prefix' => 'companies'], function () use ($router) {
    Route::get('/', 'Company\CompanyController@index');
    Route::post('/', ['middleware' => 'auth', 'uses' => 'Company\CompanyController@store']);
    Route::get('/{id:[0-9]+}', 'Company\CompanyController@show');
    Route::put('/{id:[0-9]+}', ['middleware' => 'auth', 'uses' => 'Company\CompanyController@update']);
    Route::delete('/{id:[0-9]+}', ['middleware' => 'auth', 'uses' => 'Company\CompanyController@destroy']);
});

$router->group(['prefix' => 'employees'], function () use ($router) {
    Route::get('/', 'Employee\EmployeeController@index');
    Route::post('/', ['middleware' => 'auth', 'uses' => 'Employee\EmployeeController@store']);
    Route::get('/{id:[0-9]+}', 'Employee\EmployeeController@show');
    Route::put('/{id:[0-9]+}', ['middleware' => 'auth', 'uses' => 'Employee\EmployeeController@update']);
    Route::delete('/{id:[0-9]+}', ['middleware' => 'auth', 'uses' => 'Employee\EmployeeController@destroy']);
});

$router->group(['prefix' => 'registers'], function () use ($router) {
    Route::post('/', 'Auth\AuthController@doRegister');
    Route::get('/validate', 'Auth\AuthController@validateRegister');
});

Route::post('/logins', 'Auth\AuthController@doLogin');

$router->get('/files', function () use ($router) {
    return 'Test Service Api';
});
Route::get('/files/{name}','FileManager\FileController@show');