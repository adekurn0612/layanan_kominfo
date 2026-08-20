<?php

namespace App\Http\Requests;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRolePermissionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('role')) ?? false;
    }

    public function rules(): array
    {
        $restrictedPermissionIds = $this->user()?->isSuperAdmin()
            ? []
            : Permission::whereIn('code', Permission::SENSITIVE_CODES)->pluck('id')->all();

        return [
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id', Rule::notIn($restrictedPermissionIds)],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
