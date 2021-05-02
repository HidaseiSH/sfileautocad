<?php

namespace App\Listeners;

use App\Events\FileDownloadUpload;
use App\Models\UserFileAudit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveFileAudit
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FileDownload  $event
     * @return void
     */
    public function handle(FileDownloadUpload $event)
    {
        $file_audit = new UserFileAudit();
        $file_audit->type = $event->type;;
        $file_audit->result = $event->result;
        $file_audit->user_id = Auth::user()->id;
        $file_audit->file_id = $event->id;
        $file_audit->save();
    }
}
