<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\SendReviewOnConfirmationRequest;
use App\Models\KoronaPendingReview;
use App\Models\KoronaReview;
use App\Http\Resources\KoronaReviewResource;
use Illuminate\Http\Request;

class SendOnConfirmationController extends Controller
{
    public function __invoke(SendReviewOnConfirmationRequest $request)
    {
        $data = $request->validated();
        $review = KoronaPendingReview::create($data);
        return response()->json(['message' => 'Отзыв отправлен на модерацию. Спасибо!']);
    }
}
