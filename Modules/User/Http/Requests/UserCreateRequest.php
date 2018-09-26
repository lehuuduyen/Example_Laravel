<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'repassword'=>'required|same:password',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages(){
        return[
            'name.required'=>'Vui lòng nhập tên tài khoản',
            'email.required'=>'Vui lòng nhập email',
            'password.required'=>'Vui lòng nhập password',
            'repassword.required'=>'Vui lòng nhập RePassword',
            'repassword.same'=>'Password và RePassword phải giống nhau',

        ];
    }
}
