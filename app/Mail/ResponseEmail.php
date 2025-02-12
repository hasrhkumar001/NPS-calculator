<?php

namespace App\Mail;

use App\Models\Question;
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
    public $questions =[];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($surveyData)
    {
       
        $this->surveyData = $surveyData;
        $idsGroupId = $surveyData['idsGroup_id'];
        $questionsData = Question::where('group_id', $idsGroupId)->first();
            //  dd($questionsData);
             
             if ($questionsData) {
                 $this->questions = [
                     1 => $questionsData->Q1,
                     2 => $questionsData->Q2,
                     3 => $questionsData->Q3,
                     4 => $questionsData->Q4,
                     5 => $questionsData->Q5,
                     6 => $questionsData->Q6,
                     7 => $questionsData->Q7,
                     8 => $questionsData->Q8,
                     9 => $questionsData->Q9
                 ];
             }
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
                    ->with([
                        'surveyData' => $this->surveyData,
                        'questions' => $this->questions
                    ]);
    }
    
}
