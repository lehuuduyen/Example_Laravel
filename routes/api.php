<?php
	use Dingo\Api\Routing\Router;
	/** @var Router $api */
	$api = app( Router::class );
	$api->version( 'v1',function ( Router $api ){
		$api->group( [ 'prefix' => 'auth' ],function ( Router $api ){
			$api->post( 'signup','App\\Api\\V1\\Controllers\\SignUpController@signUp' );
			$api->post( 'login','App\\Api\\V1\\Controllers\\LoginController@login' );
			$api->post( 'recovery','App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail' );
			$api->post( 'reset','App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword' );
			$api->post( 'logout','App\\Api\\V1\\Controllers\\LogoutController@logout' );
			$api->post( 'refresh','App\\Api\\V1\\Controllers\\RefreshController@refresh' );
			$api->get( 'me','App\\Api\\V1\\Controllers\\UserController@me' );
		} );
		//Login lt
		$api->group( [ 'prefix' => 'user' ],function ( Router $api ){
			$api->get( '{id}','Modules\\User\\Http\\Controllers\\UserController@show' );
			$api->get( '','Modules\\User\\Http\\Controllers\\LoginController@get_user' );
			$api->post( 'login','Modules\\User\\Http\\Controllers\\LoginController@login' );
			$api->post( 'signup','Modules\\User\\Http\\Controllers\\SignUpController@signUp' );
			$api->post( 'logout','Modules\\User\\Http\\Controllers\\LogoutController@logout' );
			$api->post( 'check_login','Modules\\User\\Http\\Controllers\\LoginController@check_login' );
		} );
		//company
		$api->group( [
			'prefix'    => 'company',
			'namespace' => 'Modules\\Company\\Http\\Controllers\\'
		],function ( Router $api ){
			$api->get( 'all','CompanyController@all' );
			$api->post( 'search','CompanyController@search' );
			$api->get( '{id}','CompanyController@get_by_id' );
			$api->post( 'toado','CompanyController@toado' );
		} );
		//Customer
		$api->group( [
			'prefix'    => 'customer',
			'namespace' => 'Modules\\Customer\\Http\\Controllers\\'
		],function ( Router $api ){
			$api->put( 'update','CustomerController@updateapi' );
			$api->post( 'toado','CustomerController@toado' );
			$api->post( 'avatar','CustomerController@avatar' );
			$api->post( 'search','CustomerController@search' );
			$api->post( 'add-cus','CustomerController@add' );
		} );
		//Help
		$api->group( [ 'prefix' => 'help' ],function ( Router $api ){
			$api->get( 'all','Modules\\Help\\Http\\Controllers\\HelpController@all' );
			$api->get( '','Modules\\Help\\Http\\Controllers\\HelpController@get_by_token' );
			$api->post( '','Modules\\Help\\Http\\Controllers\\HelpController@store_api' );
		} );
		//News
		$api->group( [ 'prefix' => 'news' ],function ( Router $api ){
			$api->get( 'all','Modules\\News\\Http\\Controllers\\NewsController@all' );
			$api->get( '{id}','Modules\\News\\Http\\Controllers\\NewsController@get_by_id' );
		} );
		//Notification
		$api->group( [ 'prefix' => 'notification' ],function ( Router $api ){
			$api->get( '','Modules\\Notification\\Http\\Controllers\\NotificationController@get_by_token' );
		} );
		$api->group( [ 'prefix' => 'help' ],function ( Router $api ){
			$api->post( 'add','App\\Api\\V1\\Controllers\\HelpController@add' );
			$api->post( 'add/{id}','App\\Api\\V1\\Controllers\\HelpController@add_detail' );
		} );
		$api->group( [ 'middleware' => 'jwt.auth' ],function ( Router $api ){
			$api->get( 'protected',function (){
				return response()->json( [
					'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
				] );
			} );
			$api->get( 'refresh',[
				'middleware' => 'jwt.refresh',
				function (){
					return response()->json( [
						'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
					] );
				}
			] );
		} );
	} );
