<?php

namespace App\Http\Livewire\Admin\Activities;

use App\Events\FileDownloadUpload;
use App\Models\Activity;
use App\Models\User;
use App\Models\UserFileAudit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class GetFiles extends Component
{
    public $activity_id;
    public $file_url, $file_id;
    public $password;
    public $alert_password = false;

    public function mount($id){
        $this->activity_id = $id;
    }
    public function render()
    {
        $activity = Activity::find($this->activity_id);
        $files = $activity->files;
        return view('livewire.admin.activities.get-files',[
            'activity' => $activity,
            'files' => $files
        ]);
    }

    protected function getListeners()
    {
        return ['download'];
    }

    public function set_url($id,$url){
        $this->file_url = $url;
        $this->file_id = $id;
        $this->emit('open_modal');
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
