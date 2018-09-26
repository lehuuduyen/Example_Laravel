<?php

    namespace App\Api\V1\Requests;

    use Dingo\Api\Http\FormRequest;

    class BaseRequest extends FormRequest
    {
        /**
         * Get only filed validation
         * And support add user_id to data request
         *
         * @param bool $hasUserID
         * @return array
         */
        public function dataOnly($hasUserID = FALSE)
        {
            $data = $this->only(array_keys($this->rules()));
            if ($hasUserID) {
                $data['user_id'] = \Auth::user()->id;
            }

            return $data;
        }
    }
