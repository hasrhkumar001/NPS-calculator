<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $clientContactName;
    public $idsLeadManager;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientContactName, $idsLeadManager)
    {
        $this->clientContactName = $clientContactName;
        $this->idsLeadManager = $idsLeadManager;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        return $this->view('emails.survey')
                    ->subject('Customer Satisfaction Survey')
                    ->with([
                        'clientContactName' => $this->clientContactName,
                        'idsLeadManager' => $this->idsLeadManager,
                    ]);
    }
    

    
    

   
}
