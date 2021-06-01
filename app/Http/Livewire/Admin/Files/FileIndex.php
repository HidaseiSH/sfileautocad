<?php

namespace App\Http\Livewire\Admin\Files;

use App\Events\FileDownloadUpload;
use App\Models\Activity;
use App\Models\ActivityFiles;
use App\Models\File;
use App\Models\User;
use App\Models\UserFileAudit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FileIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $file, $description, $alert = false, $alert_error = false, $file_type, $alert_error_type = false;
    public $activity_id;
    public $disabled,$file_type_filter,$password;
    public $file_id,$file_url,$alert_password = false;


    public function render()
    {
        if(empty($this->file) || empty($this->description)){
            $this->disabled = true;
        }else{
            $this->disabled = false;
        }
        
        $get_files = File::where('user_id', Auth::user()->id)
                    ->when($this->file_type_filter, function($query, $data){
                        return $query->where('file_type',$data);
                    })
                    ->latest('id')
                    ->paginate(10);
        $activities = Activity::where('close_date','>=', date('Y-m-d H:i:s'))->get();
        return view('livewire.admin.files.file-index',compact('get_files','activities'));
    }

    protected function getListeners()
    {
        return ['download'];
    }

    public function upload_file(){
        Validator::make(
            ['file_type' => $this->file_type,
            'description' => $this->description,
            'file' => $this->file],
            [   'file_type' => 'required',
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
                'file_type.required' => 'El campo Tipo de Archivo es obligatorio.',
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
            $filen->file_type = $this->file_type;
            $filen->description = $this->get_descripction($this->description);
            $filen->user_id = Auth::user()->id;
            if($this->activity_id){
                $act = Activity::where('id',$this->activity_id)->first();
                if($act->accept_file_type != $this->file_type){
                    $this->alert_error_type = true;
                    return;
                }
            }
            if($filen->save()){
                $filen->refresh();
                if($this->activity_id){
                    $af = new ActivityFiles;
                    $af->file_id = $filen->id;
                    $af->activity_id = $this->activity_id;
                    $af->user_id = Auth::user()->id;
                    if($af->save()){
                        FileDownloadUpload::dispatch(UserFileAudit::RESULT_SUCCESS,UserFileAudit::TYPE_UPLOAD,$filen->id);
                        $this->alert = true;
                        $this->alert_error = false;
                    }else{
                        $filen->delete();
                        FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_UPLOAD,null);
                        $this->alert_error = true;
                        $this->alert = false;
                    }
                }else{
                    FileDownloadUpload::dispatch(UserFileAudit::RESULT_SUCCESS,UserFileAudit::TYPE_UPLOAD,$filen->id);
                    $this->alert = true;
                    $this->alert_error = false;
                }
            }else{
                FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_UPLOAD,null);
                $this->alert_error = true;
                $this->alert = false;
            }
            $this->reset('file', 'description','activity_id','file_type');
        } catch (Exception $e) {
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR,UserFileAudit::TYPE_UPLOAD,null);
            $this->alert_error = true;
            $this->alert = false;
        }
    }
    public function set_url($id,$url){
        $this->file_url = $url;
        $this->file_id = $id;
        $this->emit('open_modal');
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

    public function password_confirm(){
        Validator::make(
            ['password' => $this->password,],
            [  
                'password' => ['required'],
            ],
            [
                'password.required' => 'La contraseña es obligatoria.',
            ]
            )
            ->validate();
        $user = User::where('email', Auth::user()->email)->first();
        if ($user && Hash::check($this->password, $user->password)) {
            $this->emit('close_modal',$this->file_id,$this->file_url);
            $this->reset(['file_id','file_url','password','alert_password']);
        }else{
           $this->alert_password = true;
        }
    }
}
