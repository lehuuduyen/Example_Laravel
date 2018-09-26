<?php
	
	namespace Modules\User\Http\Controllers;
	use App\Http\Controllers\BaseController;
    use http\Env\Response;
    use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Redirect;
    use Modules\MyCore\Entities\Employee;
    use Modules\MyCore\Entities\SysApp;
	use Modules\MyCore\Entities\SysAppEmployee;
	use Modules\MyCore\Entities\SysAppPermission;
	use Modules\User\Entities\ModelRole;
	use Modules\User\Entities\Permission;
	use Modules\User\Entities\Role;
	use Modules\User\Entities\RolePermission;
    use Modules\User\Entities\User;
    use Symfony\Component\HttpKernel\Exception\HttpException;
	use Tymon\JWTAuth\JWTAuth;
	use App\Http\Controllers\Controller;
	use App\Api\V1\Requests\LoginRequest;
	use Tymon\JWTAuth\Exceptions\JWTException;
	use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
	use Auth;
	use DB;
	use Illuminate\Foundation\Auth\AuthenticatesUsers;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Psr7;
	class LoginController extends BaseController{
		/**
		 * Log the user in
		 *
		 * @param LoginRequest $request
		 * @param JWTAuth      $JWTAuth
		 * @return \Illuminate\Http\JsonResponse
		 */
		public $_data;
		use AuthenticatesUsers;
		public function login( LoginRequest $request,JWTAuth $JWTAuth ){
			
			$credentials = $request->only( [
				'email',
				'password'
			]);
            $error=User::where('email',$credentials['email'])->get();
            if(count($error)==0){
                return $this->responseServerError("Không có tên đăng nhập");
            }
			try{
				if( filter_var( $credentials['email'],FILTER_VALIDATE_EMAIL ) ){
					$token = Auth::guard( 'api' )->attempt( [
						'email'    => $credentials['email'],
						'password' => $credentials['password']
					] );
				}
				if( ! $token ){
					throw new AccessDeniedHttpException();
				}
			}catch( JWTException $e ){
				throw new HttpException( 500 );
			}
			if( isset( $request->url ) ){
				$url = $request->url;
			}else{
				$url = "gateway-login.dev-altamedia.com";
			}
			$id=Auth::guard('api')->user()->id;
            if( $request->sys_app_id!=''&& $request->sys_app_id!=24 ){
                $sys_app_id = $request->sys_app_id;
                $Employee=Employee::where('user_id',$id)->first();
                $sysApp_Emp=SysAppEmployee::where('employee_id',$Employee->id)->where('sys_app_id',$sys_app_id)->first();
                if(count($sysApp_Emp)==0){
                    return $this->responseServerError("Không có quyền vào sever");
                }
            }if($request->sys_app_id==''|| $request->sys_app_id==24){
                $Employee=Employee::where('user_id',$id)->first();
                $sysApp_Emp=SysAppEmployee::where('employee_id',$Employee->id)->where('sys_app_id',24)->first();
                if(count($sysApp_Emp)==0){
                    return $this->responseServerError("Không có quyền vào sever");
                }
                return $this->responseSuccess( 'gateway-login.dev-altamedia.com?token=' . $token);
            }

			$id=Auth::guard('api')->user()->id;



            $data=$this->getRolePermission($id,$sys_app_id,$credentials);
            $url_app=SysApp::find($sys_app_id)->url_callback;
            if($url_app==""){
                return $this->responseServerError("Không có url api");
            }
            $url_app=$url_app.'/api/user/store/all';
            $client = new Client();

            $response = $client->request( 'post',$url_app,[
                'headers'     => [
                    'Authorization' => session( 'token' ),
                ],
                'json' => $data   ,
                'http_errors' => TRUE
            ] );
            $code     = $response->getStatusCode(); // 200
            $body     = $response->getBody();
            $arrBody  = json_decode( $body );
//            return $this->responseServerError($url . '?token='.$body);
            return $this->responseSuccess($url . '?token=' . $body);
		}
		public function getlogin( Request $request ){
			$this->_data['url'] = $request->get( 'url' );
			
			return view( 'user::login',$this->_data );
		}
		public function postlogin( LoginRequest $request ){
			
			$credentials = $request->only( [
				'user',
				'password'
			] );
			try{
				if( filter_var( $credentials['user'],FILTER_VALIDATE_EMAIL ) ){
					$token = Auth::guard()->attempt( [
						'email'    => $credentials['user'],
						'password' => $credentials['password']
					] );
				}else{
					$token = Auth::guard()->attempt( [
						'phone'    => $credentials['user'],
						'password' => $credentials['password']
					] );
				}
				if( ! $token ){
					throw new AccessDeniedHttpException();
				}
			}catch( JWTException $e ){
				throw new HttpException( 500 );
			}
			
			return response()->json( [
				'status'     => 200,
				'msg'        => 'success',
				'token'      => $token,
				'expires_in' => Auth::guard()->factory()->getTTL() * 60,
				'user'       => Auth::guard()->user()
			] );
		}
		public function get_user( Request $request ){
			if( ! empty( Auth::guard( 'api' )->user() ) ){
				$user = Auth::guard( 'api' )->user();
				$user['employee']=$user->employee();
				return $this->responseSuccess( $user );
			}
			
			return $this->responseServerError( 'Token có lỗi' );
		}
		public function check_login( Request $request ){
			if( ! empty( Auth::guard( 'api' )->user() ) ){
				$user       = Auth::guard( 'api' )->user();
                $sys_app_id = SysApp::find($request->sys_app_id );
                if( count( $sys_app_id ) == 0 ){
					return $this->responsePermissionDenied( 'Not SysApp' );
				}
				$permission = Permission::where( 'name',$request->permission )->where( 'sys_app_id',$sys_app_id->id )->first();
                if( count( $permission ) == 0 ){
					return $this->responsePermissionDenied( 'Not Permission2' );
				}
				$role_permission = SysAppPermission::
				where( 'permission_id',$permission->id )->get();
				foreach( $role_permission as $value ){
					$ModelRole = ModelRole::
					where( 'role_id',$value->role_id )->where( 'model_id',$user->id )->first();
					if( $ModelRole ){
						//return user data
						return $this->responseSuccess( $user );
					}
				}
				
				return $this->responsePermissionDenied( 'Not Permission3' );
			}else{
				return $this->responseNotAuthorize();
			}
		}
		public function getlogout(){
			session()->forget( 'userData' );
			
			//var_dump( session('userData'));exit();
			return redirect( './user/login' );
		}
		public  function getRolePermission($id,$app,$credentials){
		    $model_has_roles=ModelRole::where('model_id',$id)
                ->pluck('role_id')
                ->toArray();

		    $data_model_has_roles=ModelRole::where('model_id',$id)
                ->get();

		    //vai tro trong app
            $role=Role::whereIn('id',$model_has_roles)
                ->where('sys_app_id',$app)
                ->pluck('id')
                ->toArray();

            $data_role=Role::whereIn('id',$model_has_roles)
                ->where('sys_app_id',$app)
                ->get();


            //quyen vai tro trong app
            $role_permission=RolePermission::whereIn('role_id',$role)
                ->pluck('permission_id')
                ->toArray();

            $data_role_permission=RolePermission::whereIn('role_id',$role)
                ->get();

            //quyen trong app
            $data_permission=Permission::whereIn('id',$role_permission)
                ->get();

            return response()->json([
                'model_has_roles'=>$data_model_has_roles,
                'role'=>$data_role,
                'role_permission'=>$data_role_permission,
                'permission'=>$data_permission,
                'user'   =>Auth::guard('api')->user(),
                'credentials'=>$credentials
            ]);


        }


        public function storeAll(Request $request){
            $data=$request->original;
            $model_has_roles=$data['model_has_roles'];
            $role=$data['role'];
            $role_permission=$data['role_permission'];
            $permission=$data['permission'];

            //data user
            $credentials=$data['credentials'];
            $user=$data['user'];
            $user_id=$user['id'];
            $credentials['name']=$user['name'];
            $credentials['id']=$user_id;


            \DB::beginTransaction();
            //user

            $success=$this->checkUser($user_id);
            try {
                $add_user=User::create($credentials);

            } catch (\Exception $e) {
                \DB::rollBack();
                return $this->response->errorInternal($e->getMessage());
            }

            foreach ($permission as $value)
            {
                $id_permission_user=$value['id'].$user_id;
                $success=$this->checkUser($id_permission_user);
                //permission
                try {
                    Permission::create([
                        'id'=>$id_permission_user,
                        'name'=>$value['name'],
                        'guard_name'=>$value['guard_name'],
                        'description'=>$value['description'],
                    ]);

                } catch (\Exception $e) {
                    \DB::rollBack();
                    return $this->response->errorInternal($e->getMessage());
                }

                //model_permission
                try {
                    ModelPermission::create([
                        'permission_id'=>$id_permission_user,
                        'model_id'=>$user_id,
                        'model_type'=>'App\User',

                    ]);

                } catch (\Exception $e) {
                    \DB::rollBack();
                    return $this->response->errorInternal($e->getMessage());
                }

            }
            \DB::commit();

            try{
                if( filter_var( $credentials['email'],FILTER_VALIDATE_EMAIL ) ){
                    $token = Auth::guard( 'api' )->attempt( [
                        'email'    => $credentials['email'],
                        'password' => $credentials['password']
                    ] );
                }
                if( ! $token ){
                    throw new AccessDeniedHttpException();
                }
            }catch( JWTException $e ){
                throw new HttpException( 500 );
            }




            return $token;
        }

        public function checkUser($id){
            $user=User::find($id);
            \DB::beginTransaction();
            try {
                User::destroy($id);
            } catch (\Exception $e) {
                \DB::rollBack();
                return $this->response->errorInternal($e->getMessage());
            }
            try {
                $permission=Permission::destroy($id);
                ModelPermission::where('permission_id',$id)->delete();
            } catch (\Exception $e) {
                \DB::rollBack();
                return $this->response->errorInternal($e->getMessage());
            }
            \DB::commit();
            return "success";


        }
	}
