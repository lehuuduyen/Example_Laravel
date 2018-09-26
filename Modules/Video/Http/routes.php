<?php

Route::group(['middleware' => 'web', 'prefix' => 'video', 'namespace' => 'Modules\Video\Http\Controllers'], function()
{
    Route::get('/', 'VideoController@index');
});

use Dingo\Api\Routing\Router;

$api = app(Router::class);
$api->version('v1', function (Router $api) {
    $api->group([
        'prefix' => 'video',
        'namespace' => 'Modules\Video\Http\Controllers'
    ], function (Router $api) {

        $api->post('/store', 'VideoController@store');

    });
});