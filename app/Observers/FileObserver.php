<?php

namespace App\Observers;

use App\Models\File;
use App\Models\UserFileAudit;
use Illuminate\Events\Dispatcher;

class FileObserver
{
    //protected $events;
    // public function __construct(Dispatcher $dispatcher)
    // {
    //     $this->events = $dispatcher;
    // }
    /**
     * Handle the File "created" event.
     *
     * @param  \App\Models\File  $file
     * @return void
     */
    public function created(File $file)
    {
        //$file->refresh();
        $file_audit = new UserFileAudit();
        $file_audit->type = UserFileAudit::TYPE_UPLOAD;
        $file_audit->user_id = $file->user->id;
        $file_audit->file_id = $file->id;
        $file_audit->save();
    }

    /**
     * Handle the File "updated" event.
     *
     * @param  \App\Models\File  $file
     * @return void
     */
    public function updated(File $file)
    {
        //
    }
}
