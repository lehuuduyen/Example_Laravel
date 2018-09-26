<?php
	
	namespace Modules\User\Http\Controllers;
	use App\Http\Controllers\Controller;
	use Auth;
	class LogoutController extends Controller{
		/**
		 * Create a new AuthController instance.
		 *
		 * @return void
		 */
		public function __construct(){
			$this->middleware( 'auth:web',[] );
		}
		/**
		 * Log the user out (Invalidate the token)
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function logout(){
			
			Auth::guard()->logout();
			
			return redirect( 'user/login' );
		}
	}
