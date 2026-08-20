<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('user')) ?? false;
    }

    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');
        $restrictedRoleIds = $this->user()?->isSuperAdmin()
            ? []
            : Role::where('code', Role::SUPER_ADMIN_CODE)->pluck('id')->all();

        return [
            'organization_id' => ['nullable', 'exists:organizations,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['array'],
            'roles.*' => ['exists:roles,id', Rule::notIn($restrictedRoleIds)],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
