<?php

namespace App\Http\Livewire\Admin\Data;

use App\Models\File;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FileResultIndex extends Component
{
    public $search;
    public $type = 'month', $year, $month;
    public function render()
    {
        $years = DB::table('user_file_audits')
                    ->select(DB::raw('YEAR(created_at) as year'))
                    ->groupBy('year')
                    ->get();
        return view('livewire.admin.data.file-result-index', compact('years'));
    }

    public function clear_select(){
        $this->reset('month','year');
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

    public function send_data_bar_file($description,$id){
        
        $data = DB::table('user_file_audits')
                ->select(DB::raw("file_id,".$this->type."(created_at) as ".$this->type.",SUM(result ='error') count_error, SUM(result ='success') count_success"))
                ->where('type','download')
                ->where('file_id',$id)
                ->when($this->month, function($query, $data){
                    return $query->whereYear('created_at',$this->year)
                                    ->whereMonth('created_at',$this->month);
                })
                ->when($this->year, function($query, $data){
                    return $query->whereYear('created_at',$this->year);
                })
                ->groupBy('file_id',$this->type)
                ->get();
        
        $arr_info = [];
        if($this->year && $this->month){
            $arr_info = [
                'type' => $this->type,
                'year' => $this->year,
                'month' => $this->month,
            ];
        }
        $this->emit('get_data_file',$data, $description, $arr_info);
        $this->reset('search');
    }

    public function getResultsProperty(){
        $search_data = $this->get_description($this->search);
        return File::where('description', 'LIKE', '%'.  $search_data . '%')
                        ->take(8)->get();
    }

    public function get_description($description){
        return strtolower(str_replace(' ','_',$description));

    }
}
