<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    public function rules(): array
    {
        return [
            'password' => ['min:8', 'confirmed'],
            'country' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
        ];
    }
}
