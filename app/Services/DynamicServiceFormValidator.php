<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DynamicServiceFormValidator
{
    public function validate(Request $request, Service $service): array
    {
        $rules = [];
        $attributes = [];

        foreach ($service->activeFields as $field) {
            $key = "fields.{$field->name}";
            $rules[$key] = $this->rulesForField($field);
            $attributes[$key] = $field->label;
        }

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated()['fields'] ?? [];
    }

    private function rulesForField(ServiceField $field): array
    {
        $rules = [$field->is_required ? 'required' : 'nullable'];

        $rules[] = match ($field->type) {
            'email' => 'email',
            'number' => 'numeric',
            'date' => 'date',
            'datetime' => 'date',
            'phone' => 'regex:/^[0-9+().\\-\\s]+$/',
            'file' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
            'checkbox' => 'array',
            default => 'string',
        };

        if (in_array($field->type, ['select', 'radio'], true)) {
            $options = implode(',', array_map(fn ($option) => str_replace(',', '\,', (string) $option), $field->normalizedOptions()));
            $rules[] = "in:{$options}";
        }

        foreach ($field->validation_rules ?? [] as $rule) {
            $rules[] = $rule;
        }

        return $rules;
    }
}
