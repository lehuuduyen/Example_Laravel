<?php
	
	namespace Modules\User\Http\Controllers;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Auth;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use DB;
	class PermissionController extends Controller{
		public function __construct(){
		
		}
		public function index(){
			//$data = DB::table('roles')->orderBy('id', 'desc')->get()->toArray();
			$permissions = Permission::orderBy( 'id','desc' )->get()->toArray();
			//echo"<pre>";print_r($data);die;
			$this->_data['permissions'] = $permissions;
			$data                       = Role::orderBy( 'id','desc' )->get()->toArray();
			$this->_data['roles']       = $data;
			$this->_data['stt']         = 1;
			
			return view( 'user::permissions.index',$this->_data );
		}
		public function store( Request $request ){
			$object              = Permission::create( [
				'name'       => $request->txt_permission,
				'guard_name' => 'web'
			] );
			$object->description = $request->description;
			$object->save();
			
			return redirect()->back()->with( [
				'flash_level'   => 'success',
				'flash_message' => 'Bạn thêm dữ liệu thành công!!!'
			] );
		}
		public function update( Request $request,$id ){
			$permission              = Permission::find( $id );
			$permission->name        = $request->name;
			$permission->description = $request->description;
			$permission->save();
			$roles = Role::All()->toArray();
			foreach( $roles as $v ){
				$role = Role::find( $v['id'] );
				$permission->removeRole( $role );
			}
			if( count( $request->data ) > 0 ){
				foreach( $request->data as $v ){
					$role = Role::find( $v );
					$permission->assignRole( $role );
				}
			}
			
			return response()->json( [
				'status' => 'ok'
			] );
		}
		public function delete( $id ){
			$permission = Permission::findOrFail( $id );
			$permission->delete();
			
			return redirect()->back()->with( [
				'flash_level'   => 'success',
				'flash_message' => 'Bạn cập nhật dữ liệu thành công!!!'
			] );
		}
		public function getRoleOne( $id ){
			
			$data = DB::table( 'role_has_permissions as a' )->rightjoin( 'permissions as b','a.permission_id','b.id' )->where( 'b.id',$id )->get();
			
			return $data;
		}
	}
