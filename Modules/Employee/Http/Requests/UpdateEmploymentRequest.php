<?php

namespace Modules\Employee\Http\Requests;


use App\Http\Requests\BaseRequest;
use Config;
use Dingo\Api\Http\FormRequest;

    class UpdateEmploymentRequest extends BaseRequest
    {
        public function rules()
        {
            return [
//                //Ca nhan
//                'birth_place'           => '',
//                'origin_place'          => '',
//                'ethnic_group'          => '',
//                'religious'             => '',
//                'normal_address'        => '',
//                'temporary_address'     => '',
//                'dob'                   => 'date',
//                //Lien lac
//                'tax_number'            => '',
//                'social_number'         => '',
//                'social_number_address' => '',
//                'social_date_create'     => 'date',
//                //Chuyen mon
//                'foreign_language'      => '',
//                'computer'              => '',
//                'education_level'       => '',
//                'academic_level'        => '',
//                'professional'          => '',
//                //Suc khoe
//                'ensurance_number'      => '',
//                'ensurance_date_create' => 'date',
//                'ensurance_address'     => '',
//                'ensurance_hospital'    => '',
//                'health'                => '',
//                'weight'                => '',
//                'height'                => '',
                "full_name" => "",
                "password" => "",
                "is_email" => "",
                "phone" => "",

            ];
        }

        public function authorize()
        {
            return TRUE;
        }
    }
