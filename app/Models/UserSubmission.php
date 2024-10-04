<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'idsGroup',
        'projectName',
        'csatOccurrence',
        'idsLeadManager',
        'clientOrganization',
        'clientContactName',
        'clientEmailAddress',
        'client_id'
    ];
    public function responses()
    {
        return $this->hasMany(Survey2Response::class, 'client_id', 'client_id');
    }
}
