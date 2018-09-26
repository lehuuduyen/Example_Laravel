<?php
	
	namespace Modules\User\Http\Controllers;
	use App\Http\Controllers\BaseController;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Auth;
	use DB;
	use Modules\Employee\Http\Controllers\EmployeeController;
	use Spatie\Permission\Traits\HasRoles;
	use Illuminate\Database\Eloquent\Model;
	use App\Modules\User\Http\Requests\CreatePostRequest;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use App\User;
	use Modules\Employee\Entities\Employment;
	class UserController extends BaseController{
		protected $guard_name = 'web';
		public function __construct(){
			//$this->middleware(['auth', 'isAdmin']);//middleware
		}
        public function role(){
            return $this->responseSuccess(Role::get());
        }
		public function index(){
			//$user = User::find(4);
			// = $user->getAllPermissions()->toArray(); echo "<pre>";print_r($permissions);die;
			//Trong test
			//$user = User::find(1);
			//echo "<pre>";print_r($user);die;
			//$role = Role::where('id', '=', 24);
			//$permissions = $user->getAllPermissions()->toArray(); echo "<pre>";print_r($permissions);die;
			//$user->assignRole('admin');die;
			//$user->assignRole($role);die;
			//End TRong test
			//$data = DB::table('roles')->orderBy('id', 'desc')->get()->toArray();
			$users = User::All()->toArray();
			//echo"<pre>";print_r($data);die;
			$this->_data['users'] = $users;
			$roles                = Role::All()->toArray();
			$this->_data['roles'] = $roles;
			$this->_data['stt']   = 1;
			
			return view( 'user::users.index',$this->_data );
		}
		public function show( $id ){
			$user = User::find( $id );
			if( ! $user ){
				return $this->responseNoContent();
			}
			
			return $this->responseSuccess( $user );
		}
		public function store( Request $request ){
			$user         = new User( $request->all() );
			$user->verify = rand( 100000,999999 );
			$roles        = $request->role;
			if( ! $user->save() ){
				throw new HttpException( 500 );
			}else{
				if( count( $roles ) > 0 ){
					foreach( $roles as $v ){
						$user->assignRole( $v );
					}
				}
			}
			
			return redirect()->back()->with( [
				'flash_level'   => 'success',
				'flash_message' => 'Bạn thêm dữ liệu thành công!!!'
			] );
		}
		public function update( Request $request,$id ){
			//echo 123;die;
			$user        = User::find( $id );
			$user->name  = $request->name;
			$user->phone = $request->phone;
			$user->email = $request->email;
			$user->save();
			$roles = Role::All()->toArray();
			foreach( $roles as $v ){
				$user->removeRole( $v['name'] );
			}
			if( count( $request->data ) > 0 ){
				foreach( $request->data as $v ){
					$user->assignRole( $v );
				}
			}
			
			return response()->json( [
				'status' => 'ok'
			] );
		}
		public function delete( $id ){
			$user = User::findOrFail( $id );
			$user->delete();
			
			return redirect()->back()->with( [
				'flash_level'   => 'success',
				'flash_message' => 'Bạn xóa dữ liệu thành công!!!'
			] );
		}
		public function getRoleOfUser( $id ){
			
			$data = DB::table( 'model_has_roles' )->where( 'model_id',$id )->select( 'role_id' )->get();
			
			return $data;
			echo "<pre>";
			print_r( $data );
			die;
			$array       = [];
			$user        = User::find( $id );
			$permissions = $user->getAllPermissions()->toArray();
			echo "<pre>";
			print_r( $permissions );
			die;
			if( count( $permissions ) > 0 ){
				foreach( $permissions as $k => $v ){
					$array[] = $v['pivot']['role_id'];
				}
				$array = array_values( array_unique( $array ) );
			}
			
			return $array;
		}
		public function getUserOne( $id ){
			$user = User::find( $id );
			
			return $user;
		}
		//Add or update employment
		public function employment( $id ){
			$employment = EmployeeController::get_id( $id )->toArray();
			//        if($employment['user_id']==null){
			//            $this->_data['infor'] = '';
			//            $this->_data['id'] = '';
			//            $this->_data['name'] = '';
			//            $this->_data['email'] = '';
			//            $this->_data['phone'] = '';
			//        }
			//        else{
			//
			//            $this->_data['id'] = $employment['user_id'];
			//            $this->_data['name'] = $employment['full_name'];
			//            $this->_data['email'] = $employment['email'];
			//            $this->_data['phone'] = $employment['phone'];
			//        }
			$this->_data['infor'] = $employment;
			//echo "<pre>"; print_r($employment);die;
			$roles                = Role::All()->toArray();
			$this->_data['roles'] = $roles;
			
			return view( 'user::employment.index',$this->_data );
		}
		public function postemployment( Request $request ){
			
			$data = $request->all();
			//echo "<pre>"; print_r($data);die;
			if( $data['user_id'] !== '' ){  //khác rỗng thì update
				$user        = User::find( $data['user_id'] );
				$user->name  = $data['name'];
				$user->phone = $data['phone'];
				$user->email = $data['email'];
				$user->save();
				$roles = Role::All()->toArray();
				foreach( $roles as $v ){
					$user->removeRole( $v['name'] );
				}
				if( count( $request->data ) > 0 ){
					foreach( $request->data as $v ){
						$user->assignRole( $v );
					}
				}
			}else{
				$user         = new User( $request->all() );
				$user->verify = rand( 100000,999999 );
				$roles        = $request->role;
				if( ! $user->save() ){
					throw new HttpException( 500 );
				}else{
					if( count( $roles ) > 0 ){
						foreach( $roles as $v ){
							$user->assignRole( $v );
						}
					}
				}
			}
			
			//        echo "<pre>"; print_r($data);die;
			return redirect( 'employee' )->with( [
				'flash_level'   => 'success',
				'flash_message' => 'Bạn thêm dữ liệu thành công!!!'
			] );
		}
	}
