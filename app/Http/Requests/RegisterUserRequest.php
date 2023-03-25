<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return !auth('sanctum')->check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'string', 'unique:users,name'],
            'password' => ['required', 'min:8', 'confirmed']
        ];
    }
}
