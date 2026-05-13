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
            'client_social_url' => ['required', 'string', 'max:100', function ($attribute, $value, $fail) {
                if (!filter_var($value, FILTER_VALIDATE_URL) && !preg_match('/^\+?[0-9\s\-]{7,}$/', $value)) {
                    $fail('Поле должно содержать ссылку или номер телефона.');
                }
            }],
            'client_social_type' => 'required|in:telegram,vk,whatsapp',
            'client_comment' => 'nullable|string',

            'delivery_method' => 'required|in:pickup,russian_post,cdek',
            'payment_method' => 'required|in:cash,online,manual',

            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }
}
