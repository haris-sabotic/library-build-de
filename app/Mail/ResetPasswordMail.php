<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $content;
    public $header;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $content = null, $header = null)
    {
        $this->link = $link;

        if ($content) {
            $this->content = $content;
            $this->header = $header;
        } else {
            $this->content = "Iskoristite sljedeći link da postavite novu lozinku.
                                                 Ukoliko niste poslali zahtjev za promjenu lozinke, ignorišite ovaj
                                                    email i link će isteći nakon određenog vremena.";
            $this->header = "Dobili smo zahtjev za promjenu vaše lozinke.";
        }
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = 'Resetovanje lozinke';
        $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($title)
            ->markdown('pages.mail.reset-password')
            ->with([
                'link' => $this->link,
                'content' => $this->content
            ]);
    }
}