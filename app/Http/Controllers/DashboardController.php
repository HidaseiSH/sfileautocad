<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserFileAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function file_result(){
        return view('admin.data.file_result');
    }

    public function data(){
        $data = DB::table('user_file_audits')
        ->select(DB::raw('MONTH(created_at) as month'))
        ->whereYear('created_at','2021')
        ->groupBy('month')
        ->get();
        
        return $data; 

    }
}