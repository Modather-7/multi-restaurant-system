<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProductRequest extends FormRequest
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
        return [
            'name'           => ['bail', 'required', 'string', 'between:3,255'],
            'restaurant_id'  => ['bail', 'required', 'integer', 'exists:restaurants,id'],
            'category_id'    => ['bail', 'required', 'integer', 'exists:categories,id'], // if null don't check for the rest of commands
            'ingredients'    => ['bail', 'required', 'string', 'max:255'],
            'price'          => ['bail', 'required', 'numeric', 'max:5000'],
            'compare_price'  => ['bail', 'nullable', 'numeric', 'max:5000'],
            'status'         => ['bail', 'required', 'in:active,draft,archived'],
            'image'          => ['bail', 'nullable', 'image', File::image()-> max(10*1024)],
            'branches'       => ['nullable', 'array'],
            'branches.*'     => ['exists:branches,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'مينفعش تسيب اسم المنتج فاضي',
            'category_id'   => 'لازم تختار نوع المنتج',
            'ingredients'   => 'لازم تكتب وصفة المنتج',
            'price'         => 'المنتج دا بكام ؟',
        ];
    }
}
