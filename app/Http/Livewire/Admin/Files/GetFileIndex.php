<?php

namespace App\Http\Livewire\Admin\Files;

use App\Events\FileDownloadUpload;
use App\Models\File;
use App\Models\User;
use App\Models\UserFileAudit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class GetFileIndex extends Component
{
    use WithPagination;

    public $password,$file_id,$file_url,$alert_password = false;


    public $search;

    public function render()
    {
        $users_id = User::whereHas(
                        'roles', function($query){
                            $query->where('name','Administrador');
                        }
                    )->select('id')->get();
        $get_files = DB::table('files')
                        ->join('users',function($join){
                            $join->on('files.user_id','=','users.id');
                        })
                        ->where(function($query) use ($users_id){
                            if(!Auth::user()->hasRole('Administrador')){
                                $query->whereIn('users.id', $users_id);
                            }else{
                                unset($users_id[Auth::user()->id]);
                                $query->whereNotIn('users.id', $users_id);
                            }
                        })
                        ->when($this->search, function($query, $data){
                            return $query->where('users.name','LIKE','%'.$data.'%');
                        })
                        ->select('files.id','files.file_type','files.description','users.name','users.email','files.url','files.created_at')
                        ->latest('files.id')
                        ->paginate(10);
        return view('livewire.admin.files.get-file-index', compact('get_files'));
    }

    protected function getListeners()
    {
        return ['download'];
    }

    public function download($id, $url){
        try {
            $result = response()->download(storage_path('app/public/'. $url));
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_SUCCESS, UserFileAudit::TYPE_DOWNLOAD,$id);
            return $result;
        } catch (Exception $e) {
            FileDownloadUpload::dispatch(UserFileAudit::RESULT_ERROR, UserFileAudit::TYPE_DOWNLOAD,$id);
        }
    }

    public function set_url($id,$url){
        $this->file_url = $url;
        $this->file_id = $id;
        $this->emit('open_modal');
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
