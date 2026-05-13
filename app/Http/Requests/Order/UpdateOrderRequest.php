<?php

namespace App\Http\Requests\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Логика авторизации (например, проверка прав пользователя)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name' => 'nullable|string|max:255',
            'client_tel' => 'nullable|string|max:30',
            'client_email' => 'nullable|email|max:255',
            'client_city' => 'nullable|string|max:255',
            'client_address' => 'nullable|string|max:500',
            'client_index' => 'nullable|string|max:20',
        ];
    }
}
