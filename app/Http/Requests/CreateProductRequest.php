<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'actual_price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'equipment' => 'nullable|array',
            'equipment.*' => 'nullable|string',
            'external_links' => 'nullable|array',
            'external_links.*' => 'nullable|url',
            'quantity' => 'required|integer|min:0',
            'views' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'название продукта',
            'description' => 'описание продукта',
            'photos' => 'изображения',
            'actual_price' => 'цена',
            'old_price' => 'старая цена',
            'category_id' => 'категория',
            'equipment' => 'оборудование',
            'external_links' => 'внешние ссылки',
            'quantity' => 'количество',
            'views' => 'количество просмотров',
        ];
    }
}
