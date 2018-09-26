<?php

Route::group(['middleware' => 'web', 'prefix' => 'danhgia', 'namespace' => 'Modules\Danhgia\Http\Controllers'], function()
{
    Route::get('test', function (){echo 123;})->middleware('role:superadmin');
    Route::group(['prefix' => 'question'], function () {
        Route::resource('', 'QuestionController');
        Route::get('anydata', 'QuestionController@anydata');
        Route::get('show/{id}', 'QuestionController@show');
        Route::put('{id}', 'QuestionController@update');
        Route::delete('/delete/{id}',['as'=>'question.delete','uses'=>'QuestionController@delete'] );


    });
    Route::group(['prefix' => 'group_question'], function () {

        Route::resource('', 'GroupQuestionController');
        Route::get('view_detail/{id}', 'GroupQuestionController@view_detail');
        Route::get('anydata', 'GroupQuestionController@anydata');
        Route::get('show/{id}', 'GroupQuestionController@show');
        Route::put('{id}', 'GroupQuestionController@update');
        Route::delete('/delete/{id}',['as'=>'question.delete','uses'=>'GroupQuestionController@delete'] );

        //detail
        Route::get('anydata_detail/{id}', 'GroupQuestionController@anydata_detail');
        Route::post('store_detail', 'GroupQuestionController@store_detail');
        Route::delete('/delete_detail/{id}/{group}',['as'=>'question.delete','uses'=>'GroupQuestionController@delete_detail'] );



    });
    Route::group(['prefix' => 'event'], function () {

        Route::resource('', 'EventController');
        Route::get('view_detail/{id}', 'EventController@view_detail');
        Route::get('anydata', 'EventController@anydata');
        Route::get('show/{id}', 'EventController@show');
        Route::put('{id}', 'EventController@update');
        Route::put('update_count/{id}', 'EventController@update_count');
        Route::delete('/delete/{id}',['as'=>'question.delete','uses'=>'EventController@delete'] );
        //detail
        Route::get('anyData_detail/{id}', 'EventController@anyData_detail');
        Route::get('get_department/{id}', 'EventController@get_department');

    });
    Route::group(['prefix' => 'reply'], function () {

        Route::get('show/{id}', 'ReplyController@show');
        Route::get('get_event/{id}', 'ReplyController@get_event');
        Route::post('',['as'=>'reply','uses'=>'ReplyController@store']);
        Route::get('success',['as'=>'success','uses'=>'ReplyController@success']);

    });

    //statistic
    Route::group(['prefix' => 'statistic'], function () {
        Route::resource('', 'StatisticController');
        Route::get('get_department/{id}', 'StatisticController@get_department');
        Route::get('anyData_detail/{id}', 'StatisticController@anyData_detail');
        Route::get('sum', 'StatisticController@sum');
        Route::get('view_detail/{id}/{user}', 'StatisticController@view_detail');



    });

});
