<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Http\Requests\CreatePostRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
class UserController extends Controller
{

	protected $guard_name = 'web';

    public function __construct() 
    {
        //$this->middleware(['auth', 'isAdmin']);//middleware 
    }

    public function index() 
    {
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

         $roles = Role::All()->toArray();
         $this->_data['roles'] = $roles;
         $this->_data['stt'] = 1;
    	return view('user::users.index',$this->_data);
    }

    public function store(Request $request) 
    {
        $user = new User($request->all());
        $user->verify = rand(100000,999999);

        $roles = $request->role;
        if(!$user->save()) {
            throw new HttpException(500);
        }else{
        	if(count($roles) > 0){
	            foreach ($roles as $v) {
	               $user->assignRole($v);
	            }
	        }
        }
        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Bạn thêm dữ liệu thành công!!!']);
    }

    public function update(Request $request, $id) 
    {
        //echo 123;die;
    	$user = User::find($id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        $roles = Role::All()->toArray();
       
    	foreach ($roles as $v) {
            $user->removeRole($v['name']);
        }
        
        if(count($request->data) > 0){
        	foreach ($request->data as  $v) {
	            $user->assignRole($v);
	        }
        }
        

        return response()
                    ->json([
                        'status' => 'ok'
                    ]);
    }


    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with(['flash_level'=>'success','flash_message'=>'Bạn xóa dữ liệu thành công!!!']);
    }

    public function getRoleOfUser($id){

        $data = DB::table('model_has_roles')->where('model_id',$id)->select('role_id')->get();
        return $data;
        echo "<pre>";print_r($data);
        die;
    	$array = [];

    	$user = User::find($id);

    	$permissions = $user->getAllPermissions()->toArray(); echo "<pre>";print_r($permissions);die;



    	if(count($permissions)>0){
    		foreach ($permissions as $k => $v) {
    			$array[] = $v['pivot']['role_id'];
    		}
    		$array = array_values(array_unique($array));
    	}
   		
   		return $array;
    }

    public function getUserOne($id){
        $user = User::find($id);
        return $user;
    }

}
