<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable,SerializesModels;

    public $details;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details)
    {  
         $this->details = $details;
    }

  
    public function build()
    {
       return $this->subject($this->details['subject'])->view('mail.testmail');
    }
}
