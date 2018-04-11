<?php

namespace App\Http\Auth\Requests;

use Dingo\Api\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:users,email|email',
            'username' => 'required|alpha_dash|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'name'     => 'required'
        ];
    }
}