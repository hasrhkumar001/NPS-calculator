<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;
    protected $table = 'users_groups'; // This will match the table name in your database

    protected $fillable = [
        'user_id',
        'group_id',
    ];

    // Relationship with Users model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with IdsGroup model
    public function group()
    {
        return $this->belongsTo(IdsGroup::class, 'group_id');
    }
}
