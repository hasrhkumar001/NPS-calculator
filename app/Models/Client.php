<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
     // The attributes that are mass assignable
     protected $table = 'clients';
     protected $fillable = [
        'name', 
        'email', 
        'organization', 
        'idsGroup',
        'user_id'
    ];
}
