<?php

namespace App\Http\Livewire\Admin\Data;

use App\Models\File;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mockery\Undefined;

class FileResultIndex extends Component
{
    public $search;
    public $year, $month;
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


    public function get_description($description){
        return strtolower(str_replace(' ','_',$description));

    }
    public function get_months($v){
        $month = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        return $month[$v];
    }

    public function own_months($v){
        $month = ['Ene','Feb','Mrz','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
        return $month[$v];
    }

    public function showInd(){
        $this->getIndOne();
        $this->getIndTwo();
        $this->getIndThree();
    }

    private function getIndOne(){
        $group = ($this->month) ? 'DAY' : 'MONTH';
        $files_success = DB::table('user_file_audits')
                ->select(DB::raw('COUNT(file_id) as files_count, '.$group.'(created_at) as '.$group))
                ->where('type','upload')
                ->where('result','success')
                ->whereYear('created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files_success = json_decode($files_success, true);
        $files =  DB::table('files')
                ->select(DB::raw('COUNT(id) as files_count, '.$group.'(created_at) as '.$group))
                ->where('file_type','Confidencial')
                ->whereYear('created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files = json_decode($files, true);
        $count = ($this->month && $this->year) ? $this->getDays() : 12;

        $arr = [];
        for ($i=1; $i <= $count; $i++) { 
            $fs = 0;
            $f = 0;
            $in = array_search($i, array_column($files_success, $group));
            if($in  !== false){
                $fs = $files_success[$in]['files_count'];
            }
            $is = array_search($i, array_column($files, $group));
            if($is !== false){
               $f = $files[$is]['files_count'];
            }
            $ind_one = round((($f == 0) ? 0 : ($fs / $f)) * 100, 1);
            $arr[] = [
                'ind_one' => $ind_one,
                'month_or_day' => (!$this->month) ? $this->own_months($i - 1) : ($i),
            ];
        }
        $des = 'Porcentaje de Resportes Confidenciales Entregados Correctamente.';
        $this->emit('get_data_file',$arr, $des);
    }

    private function getIndTwo(){
        $group = ($this->month) ? 'DAY' : 'MONTH';
        $files_success = DB::table('user_file_audits')
                ->select(DB::raw('COUNT(file_id) as files_count, '.$group.'(created_at) as '.$group))
                ->where('type','upload')
                ->where('result','success')
                ->whereYear('created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files_success = json_decode($files_success, true);
        $files =  DB::table('files')
                ->select(DB::raw('COUNT(id) as files_count, '.$group.'(created_at) as '.$group))
                ->whereYear('created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files = json_decode($files, true);
        $count = ($this->month && $this->year) ? $this->getDays() : 12;

        $arr = [];
        for ($i=1; $i <= $count; $i++) { 
            $fs = 0;
            $f = 0;
            $in = array_search($i, array_column($files_success, $group));
            if($in  !== false){
                $fs = $files_success[$in]['files_count'];
            }
            $is = array_search($i, array_column($files, $group));
            if($is !== false){
               $f = $files[$is]['files_count'];
            }
            $ind_one = round((($f == 0) ? 0 : ($fs / $f)) * 100, 1);
            $arr[] = [
                'ind_one' => $ind_one,
                'month_or_day' => (!$this->month) ? $this->own_months($i - 1) : ($i),
            ];
        }
        $des = 'Porcentaje de Resporte Integros Generados.';
        $this->emit('get_data_file_2',$arr, $des);
    }

    private function getIndThree(){
        $group = ($this->month) ? 'DAY' : 'MONTH';
        $files_over = DB::table('activity_files')
                ->join('activities',function($join){
                    $join->on('activity_files.activity_id','=','activities.id');
                })
                ->select(DB::raw('COUNT(activity_files.file_id) as files_count, '.$group.'(activity_files.created_at) as '.$group))
                ->whereRaw('DATE(activity_files.created_at) <= activities.limit_date')
                ->whereYear('activity_files.created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('activity_files.created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files_over = json_decode($files_over, true);
        $files = DB::table('activity_files')
                ->join('activities',function($join){
                    $join->on('activity_files.activity_id','=','activities.id');
                })
                ->select(DB::raw('COUNT(activity_files.file_id) as files_count, '.$group.'(activity_files.created_at) as '.$group))
                ->whereYear('activity_files.created_at',$this->year)
                ->when($this->month, function($query, $data){
                    return $query->whereMonth('activity_files.created_at',$data);
                })
                ->groupBy($group)
                ->get();
        $files = json_decode($files, true);
        $count = ($this->month && $this->year) ? $this->getDays() : 12;

        $arr = [];
        for ($i=1; $i <= $count; $i++) { 
            $fs = 0;
            $f = 0;
            $in = array_search($i, array_column($files_over, $group));
            if($in  !== false){
                $fs = $files_over[$in]['files_count'];
            }
            $is = array_search($i, array_column($files, $group));
            if($is !== false){
               $f = $files[$is]['files_count'];
            }
            $ind_one = round((($f == 0) ? 0 : ($fs / $f)) * 100, 1);
            $arr[] = [
                'ind_one' => $ind_one,
                'month_or_day' => (!$this->month) ? $this->own_months($i - 1) : ($i),
            ];
        }
        $des = 'Porcentaje de Resportes Entregados en el Plazo Establecido.';
        $this->emit('get_data_file_3',$arr, $des);
    }

    public function getDays()
    {
        if($this->month && $this->year){
            return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
        }
        return 0;
    }
}
