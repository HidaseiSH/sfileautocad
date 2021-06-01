<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityFiles;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function get(){
        return view('admin.activities.index');
    }
    public function get_files($id){
        
        return view('admin.activities.get_files', compact('id'));
    }
}
