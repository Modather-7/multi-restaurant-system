<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $admin = $this->route('admin');

        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                Rule::unique('admins', 'email')->ignore($admin?->id),
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('admins', 'username')->ignore($admin?->id),
            ],

            'password' => [
                $admin ? 'nullable' : 'required',
                'min:8',
                'confirmed',
            ],

            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('admins', 'phone_number')->ignore($admin?->id),
            ],

            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],

            'restaurant_id' => [
                'required',
                'integer',
                'exists:restaurants,id',
            ],
        ];
    }
}
