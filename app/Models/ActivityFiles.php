<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityFiles extends Model
{
    use HasFactory;

    // ONE TO MANY INVERSE
    public function activity(){
        return $this->belongsTo('App\Models\Activity');
    }

        // MANY TO MANY INVERSE
    public function files(){
        return $this->belongsToMany('App\Models\File');
    }
}
