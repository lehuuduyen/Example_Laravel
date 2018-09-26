<?php

namespace Modules\Danhgia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionRequest extends FormRequest
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
            'type'=>'required',
            'data'=>'',
            'description'=>'',
            'status'=>'',
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
    public function data_only(){
        return $this->only(array_keys($this->rules()));
    }
}
