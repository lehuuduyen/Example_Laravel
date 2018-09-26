<?php

Route::group(['middleware' => 'web', 'prefix' => 'device', 'namespace' => 'Modules\Device\Http\Controllers'], function()
{
    Route::get('/', 'DeviceController@index');
    Route::get('/dtb-list-device', 'DeviceController@DatatableListDevice')
            ->name('device.datatable');

    Route::post('/store', 'DeviceController@store')
            ->name('device.store');

    Route::delete('/destroy', 'DeviceController@destroy')
        ->name('device.destroy');
});
