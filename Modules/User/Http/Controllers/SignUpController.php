<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\BaseController;
use Config;
//use App\User;
use Modules\Customer\Entities\Customer;
use Modules\User\Entities\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Modules\User\Http\Requests\SignUpRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends BaseController
{
    public function signUp(SignUpRequest $request)
    {

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::create($request->all());
        }



        return $this->responseCreated($user);
    }
    public static function signUp_user($array)
    {

        if (filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'email'=>$array['email'],
                'name'=>$array['name'],
                'password'=>123456
                ]);
        }



        return $user->id;
    }
    public function generateRandomString($length =100) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
