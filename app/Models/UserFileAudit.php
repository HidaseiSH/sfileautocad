<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFileAudit extends Model
{
    use HasFactory;

    protected $table = "user_file_audits";
    
    protected $fillable = [
        'type', 'user_id', 'file_id'
    ];

    const TYPE_UPLOAD = 'upload';
    const TYPE_DOWNLOAD = 'download';

    const RESULT_ERROR = 'error';
    const RESULT_SUCCESS = 'success';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function file(){
        return $this->belongsTo('App\Models\File');
    }
}
