<?php

namespace App\Mail;

use App\Models\KoronaPendingReview;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewApproveMail extends Mailable
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
        return $this->subject('Ваш отзыв опубликован!')
            ->view('mail.reviews.approved')
            ->with([
                'title' => 'Ваш отзыв опубликован!',
                'name' => $this->name,
                'messageBody' => 'Ваш отзыв успешно прошёл модерацию и опубликован на нашем сайте.',
                'moderatorNote' => $this->moderatorNote,
            ]);
    }
}
