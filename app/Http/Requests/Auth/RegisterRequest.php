<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/',
                'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']
        ];
    }

    /**
     *
     * Summery: Password request validation message
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and symbol.',
            'password.regex.upper' => 'Password must contain at least one uppercase letter.',
            'password.regex.lower' => 'Password must contain at least one lowercase letter.',
            'password.regex.number' => 'Password must contain at least one number.',
            'password.regex.symbol' => 'Password must contain at least one special symbol.'
        ];
    }
}
