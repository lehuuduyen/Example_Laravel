<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Modules\User\Http\Requests\UpdateRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Modules\User\Http\Requests\CreatePostRequest;
class RoleController extends Controller
{
    public function __construct() 
    {
        //$this->middleware(['auth', 'isAdmin']);//middleware 
    }

    public function index() 
    {

        //$data = DB::table('roles')->orderBy('id', 'desc')->get()->toArray();
         $data = Role::All()->toArray();
         //echo"<pre>";print_r($data);die;
         $this->_data['data'] = $data;

         $data = Permission::All()->toArray();
         $this->_data['permissions'] = $data;
         $this->_data['stt'] = 1;
    	return view('user::roles.index',$this->_data);
    }


    public function store(CreatePostRequest $request)
    {
        //echo 123;die;
    	$object = Role::create(['name' => $request->txt_role,'guard_name' => 'web']);
        $object->description = $request->description; $object->save();

        $role = Role::find($object->id);
        $permissions = $request->permission;
        if(count($permissions) > 0){
            foreach ($permissions as $v) {
                  $permission = Permission::find($v);
                  $role->givePermissionTo($permission);
            }
        }
    

        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Bạn thêm dữ liệu thành công!!!']);
    }

    
    public function update(UpdateRequest $request, $id)
    {
    	$role = Role::find($request->id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $permissions = Permission::All()->toArray();
        if(count($permissions)>0){
        	foreach ($permissions as $v) {
	            $permission = Permission::find($v['id']);
	            $role->revokePermissionTo($permission);        
	        }
        }
        

        if(count($request->data) > 0){
        	foreach ($request->data as  $v) {
	            $permission = Permission::find($v);
	            $role->givePermissionTo($permission);        
	        }
        }
        

        return response()
                    ->json([
                        'status' => 'ok'
                    ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('user::roles.index')
            ->with('flash_message',
             'Role deleted!');
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Bạn cập nhật dữ liệu thành công!!!']);
    }


    public function getPermissionOne($id){

         $data = DB::table('role_has_permissions as a')
            ->rightjoin('roles as b', 'a.role_id','b.id')
            ->where('b.id',$id)->get();
         return $data;
    }


}
