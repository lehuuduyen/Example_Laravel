<?php

Route::group(['middleware' => 'web', 'prefix' => 'employee', 'namespace' => 'Modules\Employee\Http\Controllers'], function()
{
    Route::get('/', 'EmployeeController@index');
    Route::get('/create', "EmployeeController@create");

    Route::get('anyData', 'EmployeeController@anyData');
    Route::get('position', 'EmployeeController@position');
    Route::get('type', 'EmployeeController@type');
    Route::get('gender', 'EmployeeController@gender');
    Route::get('/{id}', 'EmployeeController@show');
    Route::post('', 'EmployeeController@store');
    Route::put('{id}', 'EmployeeController@update');
    Route::delete('delete/{id}', 'EmployeeController@delete');

    //position
//    Route::get('/position', 'EmployeeController@position');

//    Route::get('position', 'EmployeeController@position');

});
//position
