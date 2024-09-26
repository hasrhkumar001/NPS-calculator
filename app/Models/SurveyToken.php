<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyToken extends Model
{
    use HasFactory;
    protected $table= "survey_token";
    protected $fillable = ['token', 'user_submission_id', 'used'];

    public function userSubmission()
    {
        return $this->belongsTo(UserSubmission::class);
    }
}
