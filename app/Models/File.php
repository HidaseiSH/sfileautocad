<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getMyDescriptionAttribute(){
        $data = strpos($this->description,'_');
        return substr($this->description, $data + 1);
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function file_audits(){
        return $this->hasMany('App\Models\UserFileAudit');
    }
}
