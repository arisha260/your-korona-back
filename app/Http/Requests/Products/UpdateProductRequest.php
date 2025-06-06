<?php

namespace App\Http\Requests\Products;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|min:3|max:255',
            'description' => 'sometimes|string|min:10',
            'preview' => 'sometimes|file|image|max:2048',
            'photos' => 'sometimes|array',
            'photos.*' => 'file|image|max:2048',
            'existing_photos' => 'sometimes|array|min:3',
            'existing_photos.*' => 'string',
            'category_slug' => 'sometimes|string|exists:categories,slug',
            'actual_price' => 'sometimes|numeric|min:1',
            'materials' => 'sometimes|array',
            'materials.*' => 'integer|exists:materials,id',
            'equipment' => 'sometimes|string',
            'quantity' => 'sometimes|integer|min:0',
            'external_links' => 'sometimes|array',
            'external_links.telegram' => 'nullable|url',
            'external_links.vk' => 'nullable|url',
            'deleted_images' => 'sometimes|array',
            'deleted_images.*' => 'string',
        ];
    }
}
