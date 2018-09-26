<?php

namespace Modules\Employee\Http\Requests;

use App\Http\Requests\BaseRequest;
use Dingo\Api\Http\FormRequest;

class CreateEmployeeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "full_name" => "required",
            "password" => "required",
            "phone" => "",
            "is_email" => "",
            "email"     => "required|email|unique:user_details,email"
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

    public function messages()
    {
        return [
            'required'          => ':attribute bắt buộc',
            'email'             => 'Email không đúng định dạng',
            'email.unique'      => 'Email đã tồn tại',
            'phone.regex'       => 'Số điện thoại không đúng định dạng'
        ];
    }

    public function attributes()
    {
        return [
            'gender'    => 'Giới tính',
            'phone'     => 'Số điện thoại',
            'full_name' =>  'Tên',
            'email'     =>  'Email',
            'type'      =>  'Loại'
        ];
    }
}
