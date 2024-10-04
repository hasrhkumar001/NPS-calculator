<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table ="users";

    protected $fillable=[
        'name',
        'email',
        'password',
        'idsGroup',
        
        
    ];
    // public function idsGroups() {
    //     return $this->belongsToMany(IdsGroup::class,'users_groups' , 'group_id' ,'user_id')->withTimestamps();
    // }
}
