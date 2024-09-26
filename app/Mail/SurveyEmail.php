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
    public $client;
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientContactName, $idsLeadManager, $client,$token)
    {
        $this->clientContactName = $clientContactName;
        $this->idsLeadManager = $idsLeadManager;
        $this->client = $client;
        $this->token =$token;
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
                        'client' => $this->client,
                        'token' => $this->token,
                    ]);
    }
    

    
    

   
}
