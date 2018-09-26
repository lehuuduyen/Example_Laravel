<?php
//Route::get('employee/create',
//    "Modules\Employee\Http\Controllers\EmployeeController@create")->middleware(['role:superadmin|story']);
//Route::get('employee/get_id/{id}', 'Modules\Employee\Http\Controllers\EmployeeController@show')->middleware(['role:superadmin|story']);
//Route::put('employee/{id}', 'Modules\Employee\Http\Controllers\EmployeeController@update')->middleware(['role:superadmin|story']);

Route::get('employee/create',
    "Modules\Employee\Http\Controllers\EmployeeController@create");
Route::get('employee/get_id/{id}', 'Modules\Employee\Http\Controllers\EmployeeController@show');
Route::put('employee/{id}', 'Modules\Employee\Http\Controllers\EmployeeController@update');


Route::group(['prefix' => 'employee',
    'namespace' => 'Modules\Employee\Http\Controllers'], function()
{
    Route::get('/', 'EmployeeController@index');
//    Route::get('/get_id/{id}', 'EmployeeController@get_id');
    Route::get('anyData', 'EmployeeController@anyData');


    Route::get('position', 'EmployeeController@position');
    Route::get('type', 'EmployeeController@type');
    Route::get('gender', 'EmployeeController@gender');
    Route::post('', 'EmployeeController@store');
//    Route::put('{id}', 'EmployeeController@update');
    Route::delete('delete/{id}', 'EmployeeController@delete');



    //position
//    Route::get('/position', 'EmployeeController@position');

//    Route::get('position', 'EmployeeController@position');

});
//position
