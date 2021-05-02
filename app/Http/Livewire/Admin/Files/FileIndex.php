<?php

namespace App\Http\Livewire\Admin\Files;

use App\Events\FileDownloadUpload;
use App\Models\File;
use App\Models\UserFileAudit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FileIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $file, $description, $alert = false, $alert_error = false;
    public $disabled;

    public function render()
    {
        if(empty($this->file) || empty($this->description)){
            $this->disabled = true;
        }else{
            $this->disabled = false;
        }
        
        $get_files = File::where('user_id', Auth::user()->id)->latest('id')->paginate(10);
        return view('livewire.admin.files.file-index',compact('get_files'));
    }

    public function upload_file(){
        Validator::make(
            ['description' => $this->description,
            'file' => $this->file],
            [
                'description' => ['required','max:70',function($attribute, $value, $fail){
                $id = Auth::user()->id;
                $description = $this->get_descripction($value);
                $files_validate = File::where('user_id',$id)->where('description', $description);
                    if ($files_validate->count()) {
                        return $fail(__('Ingrese otra descripcion.'));
                    }
                }],
                'file' => ['required']
            ],
            [
                'description.required' => 'El campo Descripción es obligatorio.',
                'description.max' => 'El campo Descripción debe tener un maximo de 70 caracteres.',
                'file.required' => 'El campo Archivo es obligatorio.',
            ]
            )
            ->validate();
        try {
            $url = $this->file->store('files');
            $filen = new File();
            $filen->url = $url;
            $filen->description = $this->get_descripction($this->description);
            $filen->user_id = Auth::user()->id;
            if($filen->save()){
                $filen->refresh();
                FileDownloadUpload::dispatch(UserFileAudit::RESULT_SUCCESS,UserFileAudit::TYPE_UPLOAD,$filen->id);
                $this->alert = true;
                $this->alert_error = false;
            }else{
                FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_UPLOAD,null);
                $this->alert_error = true;
                $this->alert = false;
            }
            $this->reset('file', 'description');
        } catch (Exception $e) {
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_UPLOAD,null);
            $this->alert_error = true;
            $this->alert = false;
        }
    }

    private function get_descripction($data){
        $name = Auth::user()->name;
        $name = strtolower(str_replace(' ','',$name));
        return $name.'_'.strtolower(str_replace(' ','_',$data));
    }

    public function close_alert(){
        $this->reset('alert');
    }
    public function close_alert_error(){
        $this->reset('alert_error');
    }

    public function download($id, $url){
        try {
            $response = response()->download(storage_path('app/public/'.$url));
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_SUCCESS,UserFileAudit::TYPE_DOWNLOAD,$id);
            return $response;
        } catch (Exception $e) {
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_DOWNLOAD,$id);
        }
    }
}
