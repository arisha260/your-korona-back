<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class KoronaNewsRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'img' => 'nullable|string',
            'title' => 'required|string|max:70',
            'description' => 'required|string',
        ];
    }
}
