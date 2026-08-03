<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CategoryRequest extends FormRequest
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
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'bail',
                'required',
                'string',
                'between:3,255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'restaurant_id'  => ['bail', 'required', 'integer', 'exists:restaurants,id'],
            'image' => ['bail', 'nullable', 'image', File::image()-> max(10*1024)],
        ];
    }
}
