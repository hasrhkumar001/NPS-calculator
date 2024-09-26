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
        'client_id', // Foreign key to link to the UserSubmission table
        'question_index',     // Index of the question (0 for "Quality of Delivery", etc.)
        'response',           // The response value
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
