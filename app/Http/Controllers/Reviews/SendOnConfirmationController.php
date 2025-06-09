<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\SendReviewOnConfirmationRequest;
use App\Models\KoronaPendingReview;
use App\Models\Product;
use Illuminate\Support\Str;

class SendOnConfirmationController extends Controller
{
    public function __invoke(SendReviewOnConfirmationRequest $request)
    {
        $data = $request->validated();

        $product = Product::find($data['product_id']);

        $slug = Str::slug($product->title . '-' . now()->timestamp . '-' . Str::random(6));

        $review = KoronaPendingReview::create([
            'product_id' => $data['product_id'],
            'author' => $data['author'],
            'author_email' => $data['email'],
            'slug' => $slug,
            'description' => $data['description'],
            'mark' => $data['mark']
        ]);
        return response()->json(['message' => 'Отзыв отправлен на модерацию. Спасибо!']);
    }
}
