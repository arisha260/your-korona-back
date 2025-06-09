<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Mail\Reviews\ReviewApproveMail;
use App\Mail\Reviews\ReviewRejectedMail;
use App\Models\KoronaPendingReview;
use App\Models\KoronaReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ConfirmController extends Controller
{
    public function __invoke(Request $request)
    {
        DB::beginTransaction();

        try {

            $validated = $request->validate([
                'id' => 'required|exists:korona_pending_reviews,id',
                'action' => 'required|in:approve,reject',
                'message' => 'nullable|string|max:1000',
            ]);

            $review = KoronaPendingReview::findOrFail($validated['id']);

            if ($validated['action'] === 'approve') {
                KoronaReview::create([
                    'product_id' => $review->product_id,
                    'author' => $review->author,
                    'author_email' => $review->author_email,
                    'slug' => $review->slug,
                    'description' => $review->description,
                    'mark' => $review->mark,
                ]);
                Mail::to($review->author_email)->send(new ReviewApproveMail($review, $validated['message']));
            } else {
                Mail::to($review->author_email)->send(new ReviewRejectedMail($review, $validated['message']));
            }

            $review->delete();

            DB::commit();
            return response()->json('Результат подтвержден', 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Ошибка при подтверждении результата: ' . $e->getMessage()
            ], 500);
        }
    }
}
