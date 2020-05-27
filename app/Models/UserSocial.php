<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    //
    protected $table = 'user_social';
    protected $fillable = [
        'user_id',
        'social_id',
        'service',
    ];

    public function user()
    {
        return $this->hasONe('App\Models\User', 'id', 'user_id');
    }
}
