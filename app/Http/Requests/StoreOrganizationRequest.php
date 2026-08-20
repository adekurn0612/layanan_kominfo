<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Organization::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:organizations,id'],
            'code' => ['required', 'string', 'max:50', 'alpha_dash:ascii', Rule::unique('organizations', 'code')],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
