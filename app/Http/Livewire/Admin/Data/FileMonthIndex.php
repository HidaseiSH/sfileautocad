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

    public function send_data_file(){
        $this->validate([
            'year' => 'required',
            'month' => 'required',
        ]);
        $data = DB::table('user_file_audits')
        ->select(DB::raw("MONTH(created_at) as month,SUM(type ='download') download, SUM(type ='upload') upload"))
        ->whereMonth('created_at','5')
        ->whereYear('created_at','2021')
        ->groupBy('month')
        ->get()->toArray();

        $this->emit('get_data_file_two',$data);
    }
}
