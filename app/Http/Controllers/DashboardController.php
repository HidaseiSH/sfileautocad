<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\UserFileAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function file_result(){
        return view('admin.data.file_result');
    }

    public function table(){
        return view('admin.data.table');
    }

    public function data(){
        $data = DB::table('user_file_audits')
        ->select(DB::raw("MONTH(created_at) as month,SUM(type ='download') download, SUM(type ='upload') upload"))
        ->whereMonth('created_at','5')
        ->whereYear('created_at','2021')
        ->groupBy('month')
        ->get()->toArray();
       return $data;
    }
}
