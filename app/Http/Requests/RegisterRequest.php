<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'min:8'],
            'country' => ['required', 'string'],
            'state' => ['nullable', 'string'],
            'code' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'min:6']
        ];
    }
}
