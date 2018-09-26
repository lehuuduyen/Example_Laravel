<?php
	
	namespace App\Api\V1\Requests;
	class CreateCustomerRequest extends BaseRequest{
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules(){
			return [
				'email'                 => 'required|email',
				'password'              => 'required|between:6,255|confirmed',
				'password_confirmation' => 'required',
				'name'                  => 'required|min:3'
			];
		}
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize(){
			return TRUE;
		}
	}
