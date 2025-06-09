<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\SendReviewOnConfirmationRequest;
use App\Models\KoronaPendingReview;

class SendOnConfirmationController extends Controller
{
    public function __invoke(SendReviewOnConfirmationRequest $request)
    {
        $data = $request->validated();
//        $review = KoronaPendingReview::create($data);
        $review = KoronaPendingReview::create([
            'product_id' => $data['product_id'],
            'author' => $data['author'],
            'author_email' => $data['email'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'mark' => $data['mark']
        ]);
        return response()->json(['message' => 'Отзыв отправлен на модерацию. Спасибо!']);
    }
}
