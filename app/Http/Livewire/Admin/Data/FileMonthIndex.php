<?php

namespace App\Http\Livewire\Admin\Data;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FileMonthIndex extends Component
{
    public $year, $month;

    public function render()
    {
        $years = DB::table('user_file_audits')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->groupBy('year')
        ->get();
        return view('livewire.admin.data.file-month-index', compact('years'));
    }

    public function getMonthsProperty(){
        return DB::table('user_file_audits')
                    ->select(DB::raw('MONTH(created_at) as month'))
                    ->whereYear('created_at',$this->year)
                    ->groupBy('month')
                    ->get();
    }

    public function own_months($v){
        $month = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        return $month[$v - 1];
    }

    public function get_months($v){
        $month = ['Ene','Feb','Mrz','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        return $month[$v];
    }

    public function send_data_file(){
        $this->validate([
            'year' => 'required',
        ]);
        $group = $this->month ? 'DAY' :'MONTH';
        $data = DB::table('user_file_audits')
        ->select(DB::raw($group."(created_at) as ".$group.",SUM(type ='download') download, SUM(type ='upload') upload"))
        ->whereYear('created_at',$this->year)
        ->when($this->month, function($query, $data){
            return $query->whereMonth('created_at',$data);
        })
        ->groupBy($group)
        ->get();
        $data = json_decode($data, true);
        $count = ($this->month && $this->year) ? $this->getDays() : 12;
        $response = [];
        for ($i=1; $i <= $count; $i++) { 
            $download = 0;
            $upload = 0;
            $in = array_search($i, array_column($data, $group));
            if($in  !== false){
                $download = $data[$in]['download'];
                $upload = $data[$in]['upload'];
            }
            $response[] = [
                'download' => $download,
                'upload' => $upload,
                'month_or_day' => (!$this->month) ? $this->get_months($i - 1) : ($i),
            ];
        }
        $this->emit('get_data_file_two',$response);
    }

    public function getDays()
    {
        if($this->month && $this->year){
            return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        }
        return 0;
    }
}
