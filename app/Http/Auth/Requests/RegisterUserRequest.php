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
            'email'     => 'unique:users,email|email|required',
            'password'  => 'required|confirmed',
            'username'  => 'required',
            'name'      => 'required'
        ];
    }
}