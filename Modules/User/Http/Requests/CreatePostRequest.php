<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'txt_role' => 'required|unique:roles,name',
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
            'txt_role.required' => 'Vui lòng nhập tên vai trò',
            'txt_role.unique'   => 'Tên vai trò đã tồn tại',
        ];
    }
}
