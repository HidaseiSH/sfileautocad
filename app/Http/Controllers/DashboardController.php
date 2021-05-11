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

        $files = UserFileAudit::whereMonth('created_at','5')
        ->whereYear('created_at','2021')->groupBy('file_id')->pluck('file_id')->toArray();
        $data = DB::table('user_file_audits')
        ->select(DB::raw("file_id,DAY(created_at) as day,SUM(result ='error') count_error, SUM(result ='success') count_success"))
        ->where('type','download')
        ->whereMonth('created_at','5')
        ->whereYear('created_at','2021')
        ->groupBy('file_id','day')
        ->get()->toArray();
        $arr_total = [];

        foreach ($files as $value) {
            $new = $this->get_Array($data, $value);
            $data_file = [
                'name' => File::find(1)->description,
                'data' => array_values($new)
            ];
            array_push($arr_total, $data_file);
            $new = [];
            unset($value);
            
        }
        //return $this->filter_data(2, $arr_total[1]['data']);
       return $arr_total;
    }

    public function filter_data($value,$data){
        //$result = 'no';
        // foreach($data as $item) {
        //     if ($item->day == $value) {
        //         $result = $item->day;
        //         break;
        //     }
        // }
        // return $result;
        $i = array_search($value, array_column($data, 'day'));
        $result = ($i !== false ? 'si' : 'no');
        return $result;
    }

    private function get_Array($data, $value){
        return array_filter($data, function($val) use ($value){
            return $val->file_id == $value;
        });
    }
}
