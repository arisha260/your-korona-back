<?php

namespace App\Http\Requests\Products;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_slug' => 'required|exists:categories,slug',

            'preview' => 'required|image|mimetypes:image/jpeg,image/png,image/gif|max:2048',

            'photos' => 'required|array|min:3|max:10',
            'photos.*' => [
                'image',
                'mimetypes:image/jpeg,image/png,image/gif',
                'max:2048'
            ],
            'actual_price' => 'required|numeric|min:0',
            'equipment' => 'nullable|string',
            'external_links' => 'nullable|array',
            'external_links.telegram' => 'nullable|url',
            'external_links.vk' => 'nullable|url',
            'quantity' => 'required|integer|min:0',
            'materials' => 'required|array',
            'materials.*' => 'exists:materials,id',
        ];
    }
}
