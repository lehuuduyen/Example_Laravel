<?php

namespace Modules\User\Http\Controllers;

use Config;
//use App\User;
use App\Modules\User\Models\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Modules\User\Http\Requests\SignUpRequest;
use App\Modules\User\Http\Requests\CreatePostRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SignUpController extends Controller
{

    //API
    public static function signUp(SignUpRequest $request)
    {

        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = new User($request->all());
        }
        else {
            $user = new User($request->all());
            $user->email = NULL;
        }

        $user->verify = rand(100000,999999);

        if(!$user->save()) {
            throw new HttpException(500);
        }

        if(!Config::get('boilerplate.sign_up.release_token')) {

            $array = [
                'user_id' => $user->id,
                'verify' => $user->verify
            ];
            return  $array;
        }

        return response()->json([
            'status' => 'ok'
        ], 201);
    }



    //Backend
    public function getsignUp(){
        return view('user::signup');
    }

    public static function postsignUp(CreatePostRequest $request)
    {
        if(filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = new User($request->all());
        }
        else {
            $user = new User($request->all());
            $user->email = NULL;
        }

        $user->verify = rand(100000,999999);

        if(!$user->save()) {
            throw new HttpException(500);
        }
        
        

        if(!Config::get('boilerplate.sign_up.release_token')) {
            return redirect()->back();
        }

        return response()->json([
            'status' => 'ok'
        ], 201);
    }


    public function testuser(){

        $role = Role::create(['name' => 'writer']);
        //$permission = Permission::create(['name' => 'edit articles']);

        return view('user::testuser');
    }

    public function nopermission(){
        return view('user::nopermission');
    }
}
