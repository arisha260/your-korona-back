<?php

namespace App\Mail\Reviews;

use App\Models\KoronaPendingReview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewRejectedMail extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $moderatorNote;
    public function __construct(KoronaPendingReview $review, ?string $note = null)
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
        return $this->subject('Ваш отзыв отклонен!')
            ->view('mail.reviews.reject')
            ->with([
                'title' => 'Ваш отзыв был отклонен!',
                'name' => $this->name,
                'messageBody' => 'Выш отзыв не прошел проверку модератора на нашем сайте..',
                'moderatorNote' => $this->moderatorNote,
            ]);
    }
}
