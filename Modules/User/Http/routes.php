<?php
//Route::get('login', ['as'=>'user.getlogin','uses'=>'Modules\User\Http\Controllers\LoginController@getlogin']);
Route::group( [
    'middleware' => 'web',
    'prefix'     => 'user',
    'namespace'  => 'Modules\User\Http\Controllers'
],function (){
    //Route::get('/', 'User1Controller@index');
    Route::get( 'login',[
        'as'   => 'user.getlogin',
        'uses' => 'LoginController@getlogin'
    ] );
    Route::post( 'login',[
        'as'   => 'user.postlogin',
        'uses' => 'LoginController@postlogin'
    ] );
    Route::get( 'logout',[
        'as'   => 'user.getlogout',
        'uses' => 'LogoutController@logout'
    ] );
    Route::get( 'signup',[
        'as'   => 'user.getsignup',
        'uses' => 'SignUpController@getsignUp'
    ] );
    Route::get( 'role',[
        'as'   => 'user.role',
        'uses' => 'UserController@role'
    ] );
    Route::post( 'signup',[
        'as'   => 'user.postsignup',
        'uses' => 'SignUpController@postsignUp'
    ] );


    // Users resource route.
    Route::resource( 'users','UserController' )->middleware( 'role:superadmin' );
    Route::get( 'UserOne/{id}',[
        'as'   => 'user.getUserOne',
        'uses' => 'UserController@getUserOne'
    ] );
    Route::get( 'RoleOfUser/{id}',[
        'as'   => 'user.getRoleOfUser',
        'uses' => 'UserController@getRoleOfUser'
    ] );
    Route::get( 'users/delete/{id}',[
        'as'   => 'user.delete',
        'uses' => 'UserController@delete'
    ] );
    Route::get( 'employment/{id}',[
        'as'   => 'user.getEmloyment',
        'uses' => 'UserController@employment'
    ] );
    Route::post( 'employment',[
        'as'   => 'user.postEmloyment',
        'uses' => 'UserController@postemployment'
    ] );


    // Roles resource route.
    Route::resource( 'roles','RoleController' )->middleware( 'role:superadmin' );
    Route::get( 'getPermissionOne/{id}',[
        'as'   => 'role.getPermissionOne',
        'uses' => 'RoleController@getPermissionOne'
    ] );
    Route::get( 'roles/delete/{id}',[
        'as'   => 'role.delete',
        'uses' => 'RoleController@delete'
    ] );
    // Permissions resource route.
    Route::resource( 'permissions','PermissionController' )->middleware( 'role:superadmin' );
    Route::get( 'getRoleOne/{id}',[
        'as'   => 'permission.getRoleOne',
        'uses' => 'PermissionController@getRoleOne'
    ] );
    Route::get( 'permissions/delete/{id}',[
        'as'   => 'permission.delete',
        'uses' => 'PermissionController@delete'
    ] );
    // Post resource route.
    Route::resource( 'posts','PostController' );
    //Test middleware
    Route::get( 'test',function (){
        echo "Chào Admin";
    } )->middleware( [ 'permission:addadfasd' ] );
    Route::get( 'test1',function (){
        echo "Chào Super Admin";
    } )->middleware( [
        'role:superadmin',
        'permission::editasdasd'
    ] );
} );
