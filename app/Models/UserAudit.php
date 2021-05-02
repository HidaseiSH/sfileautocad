<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAudit extends Model
{
    use HasFactory;

    const ACTION_UPDATE_PASSWORD = 'update_password';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
