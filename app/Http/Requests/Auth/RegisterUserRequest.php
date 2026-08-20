<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25', 'regex:/^[0-9+()\-\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'organization_id' => ['required', 'integer', Rule::exists('organizations', 'id')->where('is_active', true)],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
