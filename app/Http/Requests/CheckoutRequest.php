<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'order_type' => ['required', 'in:delivery,pickup'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'digits_between:11,15'],
            'customer_email' => ['required', 'email', 'max:255'],
            'delivery_area_id' => ['required_if:order_type,delivery', 'nullable', 'exists:delivery_areas,id'],
            'street_address' => ['required_if:order_type,delivery', 'nullable', 'string', 'max:500'],
            'payment_method' => ['required'],
        ];
    }
}
