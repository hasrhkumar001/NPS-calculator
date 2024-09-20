<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResponseEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $surveyData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($surveyData)
    {
       
        $this->surveyData = $surveyData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Customer Satisfaction Survey')
                    ->view('emails.survey2submitted')
                    ->with('surveyData', $this->surveyData);
    }
    
}
