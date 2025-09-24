<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateSupport extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('support') ?? $this->id ?? null;

        return [
            'subject' => [
                'required',
                'string',
                'max:120',
                Rule::unique('supports', 'subject')->ignore($id),
            ],
            'body' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }
}
