<?php

namespace Modules\Video\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreVideoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'name' => 'required',
            'thumbnail' => 'required',
            'file' => 'required',
            'description' => '',
            'status' => '',
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
}
