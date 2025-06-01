<?php

namespace App\Http\Requests\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'client_name' => 'required|string|max:255',
            'client_tel' => 'required|string|max:30',
            'client_email' => 'required|email|max:255',
            'client_city' => 'nullable|string|max:255',
            'client_address' => 'nullable|string|max:500',
            'client_index' => 'nullable|string|max:20',
            'client_comment' => 'nullable|string',

            'delivery_method' => 'required|in:pickup,russian_post,cdek,courier,yandex',
            'payment_method' => 'required|in:cash,sbp,card',

            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}
