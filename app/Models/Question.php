<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    // Allow mass-assignment for these fields
    protected $fillable = [
        'group_id',             // Foreign key to link to the Client table
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
       
    ];
    public function groups()
    {
        return $this->belongsTo(IdsGroup::class, 'group_id');
    }
}
