<?php

namespace App\Mail\Reviews;

use App\Models\KoronaPendingReview;
use App\Models\KoronaReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewDeleteMail extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $moderatorNote;
    public function __construct(KoronaReview $review, ?string $note = null)
    {
        $this->name = $review->author;
        $this->moderatorNote = $note;
    }


    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Ваш отзыв был удален!')
            ->view('mail.reviews.delete')
            ->with([
                'title' => 'Ваш отзыв был удален!',
                'name' => $this->name,
                'messageBody' => 'Ваш отзыв был удален по решению администрации сайта!',
                'moderatorNote' => $this->moderatorNote,
            ]);
    }
}
