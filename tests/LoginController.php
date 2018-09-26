<?php

namespace Modules\User\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use App\Http\Requests;
use App\User;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public $_data;

    use AuthenticatesUsers;

    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['user', 'password']);

        try {
            if(filter_var($credentials['user'], FILTER_VALIDATE_EMAIL)) {
                $token = Auth::guard()->attempt(['email' => $credentials['user'], 'password' => $credentials['password']]);
            }
            else {
                $token = Auth::guard()->attempt(['phone' => $credentials['user'], 'password' => $credentials['password']]);
            }


            if(!$token) {
                throw new AccessDeniedHttpException();
            }

        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        return response()
            ->json([
                'status'=> 200,
                'msg'   => 'success',
                'token' => $token,
                'expires_in' => Auth::guard()->factory()->getTTL() * 60,
                'user' => Auth::guard()->user()
            ]);
    }

    public function getlogin(){

        // if( session()->has( 'userData' ) ){
        //     return redirect( './docter' );
        // }
        return view('user::login');
    }

    public function postlogin(LoginRequest $request){

        $auth = array(
            'email' =>$request->email,
            'password' =>$request->password,
        );


        if(Auth::attempt($auth)){
            return redirect()->intended('employee');
        }
        else{
            return redirect()->intended('user/login');
        }

        if(Auth::attempt($auth)){
            $object = json_decode(Auth::user());
            // $id = $object->id;
            // $roles = DB::table('users')->join('permissions','users.id','=','permissions.user_id')
            //                        ->join('roles','permissions.role_id','=','roles.id')
            //                        ->select('roles.name as name_role')
            //                        ->where('users.id', $id)->get();
            session(['userData' => (object)[
                'isLogin' => TRUE,
                'user'=> $object,
               // 'permissions'=> json_decode($roles)
            ]]);

            // echo "<pre>";
            // print_r(session('userData')); die;
            //echo session('userData')->user->name;
            //exit();

            //return "Dang nhap thanh cong";
            return redirect('./user/users');
        }
        else{
            return "Danh nhap that bai";
            //return redirect()->back();
        }
    }



    public function home()
    {
        return view('layout.master');
    }

    public function getlogout(){
        session()->forget('userData');

        //var_dump( session('userData'));exit();
        return redirect('./user/login');
    }
}
