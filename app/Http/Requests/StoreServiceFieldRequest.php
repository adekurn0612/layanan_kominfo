<?php

namespace App\Http\Requests;

use App\Models\Service;
use App\Models\ServiceField;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('service')) ?? false;
    }

    public function rules(): array
    {
        /** @var Service $service */
        $service = $this->route('service');

        return [
            'name' => ['required', 'string', 'max:80', 'alpha_dash:ascii', Rule::unique('service_fields', 'name')->where('service_id', $service->id)],
            'label' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(ServiceField::TYPES)],
            'placeholder' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_required' => ['nullable', 'boolean'],
            'validation_rules' => ['nullable', 'string'],
            'options' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
