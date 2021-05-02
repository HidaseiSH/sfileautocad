<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

class FileController extends Controller
{
    
    public function index(){
        return view('admin.files.index');
    }

    public function get(){
        return view('admin.files.get');
    }
}
