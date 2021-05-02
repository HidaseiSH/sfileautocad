<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Ver Auditoria');
    }

    public function files(){
        return view('admin.audits.file-index');
    }

    public function users(){
        return view('admin.audits.user-index');
    }
}
