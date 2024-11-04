<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey2Response extends Model
{
    use HasFactory;
    // Define the table if it doesn't follow Laravel's naming convention
    protected $table = 'survey_responses';

    // Allow mass-assignment for these fields
    protected $fillable = [
        'client_id',             // Foreign key to link to the Client table
        'Q1',                    // Response to question 1
        'Q2',                    // Response to question 2
        'Q3',                    // Response to question 3
        'Q4',                    // Response to question 4
        'Q5',                    // Response to question 5
        'Q6',                    // Response to question 6
        'Q7',                    // Response to question 7
        'Q8',                    // Response to question 8
        'Q9',                    // Response to question 9
        'Q10',                   // Response to question 10
        'Q11',                   // Response to question 11
        'Q12',                   // Response to question 12
        'Q13',                   // Response to question 13
        'Q14',                   // Response to question 14
        'Q15',                   // Response to question 15
        'additional_comments',   // Additional comments from the user
        'Neutral',               // Neutral response count
        'Promoter',              // Promoter response count
        'Detractor',             // Detractor response count
        'Neutral_percentage',     // Percentage of neutral responses
        'Promoter_percentage',    // Percentage of promoter responses
        'Detractor_percentage',   // Percentage of detractor responses
        'Nps_percentage',         // Overall NPS percentage
    ];

    /**
     * Relationship with UserSubmission model
     * A Survey2Response belongs to a single UserSubmission.
     */
    public function userSubmission()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
