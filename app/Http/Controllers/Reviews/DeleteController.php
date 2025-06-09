<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Mail\Reviews\ReviewDeleteMail;
use App\Models\KoronaReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DeleteController extends Controller
{
    public function __invoke($slug, Request $request)
    {
        DB::beginTransaction();

        try {

            $review = KoronaReview::where('slug', $slug)->firstOrFail();
            $validated = $request->validate([
                'message' => 'nullable|string|max:1000',
            ]);

            $review->delete();

            Mail::to($review->author_email)->send(new ReviewDeleteMail($review, $validated['message']));

            DB::commit();
            return response()->json('Отзыв удален', 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Ошибка при удалении отзыва: ' . $e->getMessage()
            ], 500);
        }
    }
}
