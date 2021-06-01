<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // ONET OT MANY
    public function activity_files(){
        return $this->hasMany('App\Models\ActivityFiles');
    }

    // ONE TO MANY THROUGH
    public function files(){
        return $this->belongsToMany('App\Models\File','activity_files');
    }
}
