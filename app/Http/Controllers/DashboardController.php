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
    public function own_months($v){
        $month = ['Ene','Feb','Mrz','Abr','May','Juni','Juli','Ago','Sep','Oct','Nov','Dic'];
        return $month[$v];
    }

    public function data(){
        $group = 'MONTH';
        $files = DB::table('activity_files')
        ->join('activities',function($join){
            $join->on('activity_files.activity_id','=','activities.id');
        })
        ->select(DB::raw('COUNT(activity_files.file_id) as files_count, '.$group.'(activity_files.created_at) as '.$group))
                //->whereRaw('DATE(activity_files.created_at) > activities.limit_date')
                ->whereYear('activity_files.created_at','2021')
                ->groupBy($group)
                ->get();
        
        return $files;
    }
}
