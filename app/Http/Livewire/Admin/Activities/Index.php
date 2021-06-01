<?php

namespace App\Http\Livewire\Admin\Activities;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Index extends Component
{
    public $alert = false, $alert_error = false;
    public $acept_type_filter;
    public $acept_type, $description, $limit_date, $close_date;

    public function render()
    {
        return view('livewire.admin.activities.index', [
            'activities' => Activity::where('user_id', Auth::user()->id)
                            ->when($this->acept_type_filter, function($query, $data){
                                return $query->where('accept_file_type',$data);
                            })
                            ->latest('id')
                            ->paginate(10)
        ]);
    }

    public function save(){
        Validator::make(
            ['acept_type' => $this->acept_type,
            'description' => $this->description,
            'limit_date' => $this->limit_date,
            'close_date' => $this->close_date],
            [   'acept_type' => 'required',
                'description' => ['required','max:200'],
                'limit_date' => ['required'],
                'close_date' => ['required']
            ],
            [
                'acept_type.required' => 'El campo Tipo de Archivo Aceptado es obligatorio.',
                'description.required' => 'El campo Descripción es obligatorio.',
                'description.max' => 'El campo Descripción debe tener un maximo de 200 caracteres.',
                'limit_date.required' => 'El campo Fecha Limite es obligatorio.',
                'close_date.required' => 'El campo Fecha de Cierre es obligatorio.',
            ]
            )
            ->validate();

            $activiy = new Activity;
            $activiy->accept_file_type = $this->acept_type;
            $activiy->description = $this->description;
            $activiy->limit_date = $this->limit_date;
            $activiy->close_date = $this->close_date;
            $activiy->user_id = Auth::user()->id;
            if($activiy->save()){
                $this->reset(['acept_type','description','limit_date','alert_error']);
                $this->alert = true;
            }else{
                $this->reset(['alert']);
                $this->alert_error = true;
            }
    }
}
