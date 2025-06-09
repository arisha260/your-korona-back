<?php

namespace App\Http\Requests\Reviews;
use Illuminate\Foundation\Http\FormRequest;

class SendReviewOnConfirmationRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'author' => 'required|string|max:255',
            'email' => 'required|email',
            'description' => 'required|string',
            'mark' => 'required|integer|between:1,5',
        ];
    }
}
