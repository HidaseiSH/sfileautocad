<?php

namespace App\Http\Livewire\Admin\Data;

use App\Models\File;
use App\Models\UserFileAudit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableIndex extends Component
{
    public $year, $month;
    public $data;

    public function mount(){
        $this->data = collect();
    }
    public function render()
    {
        $years = DB::table('user_file_audits')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->groupBy('year')
        ->get();
        return view('livewire.admin.data.table-index', compact('years'));
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

    public function getDaysMonthProperty()
    {
        if($this->month && $this->year){
            return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        }
        return 0;
    }

    public function getDaysDataProperty(){
        if($this->month && $this->year){
            $files = UserFileAudit::whereMonth('created_at',$this->month)
            ->whereYear('created_at',$this->year)->groupBy('file_id')->pluck('file_id')->toArray();
            $data = DB::table('user_file_audits')
            ->select(DB::raw("file_id,DAY(created_at) as day,SUM(result ='error') count_error, SUM(result ='success') count_success"))
            ->where('type','download')
            ->whereMonth('created_at',$this->month)
            ->whereYear('created_at',$this->year)
            ->groupBy('file_id','day')
            ->get()->toArray();
            $arr_total = [];
    
            foreach ($files as $value) {
                $new = $this->get_Array($data, $value);
                $data_file = [
                    'name' => File::find($value)->description,
                    'data' => array_values($new)
                ];
                array_push($arr_total, $data_file);
                $new = [];
                unset($value);
                
            }
            return $arr_total;
        }
        return [];
    }

    private function get_Array($data, $value){
        return array_filter($data, function($val) use ($value){
            return $val->file_id == $value;
        });
    }

    public function filter_data($value,$data){
        $result = '';
        $i = array_search($value, array_column($data, 'day'));
        if($i !== false ){
            $result = '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">';
            $result.= $data[$i]->count_error;
            $result.= '</span>';
            $result.= '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">';
            $result.= $data[$i]->count_success;
            $result.= '</span>';
        }else{
            $result = '-';
        }
        echo $result;
    }
    
}
