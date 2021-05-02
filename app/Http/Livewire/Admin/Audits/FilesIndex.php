<?php

namespace App\Http\Livewire\Admin\Audits;

use App\Events\FileDownloadUpload;
use App\Models\UserFileAudit;
use Exception;
use Livewire\Component;

class FilesIndex extends Component
{
    public $date;

    public function render()
    {
        $user_file_audits = UserFileAudit::when($this->date, function($query, $data){
                                return $query->whereDate('created_at',$data);
                            })
                            ->latest('id')->paginate(15);
        return view('livewire.admin.audits.files-index', compact('user_file_audits'));
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
}
