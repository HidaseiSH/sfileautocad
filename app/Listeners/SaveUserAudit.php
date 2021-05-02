<?php

namespace App\Listeners;

use App\Events\UserAuditType;
use App\Models\UserAudit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class SaveUserAudit
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
     * @param  UserAuditType  $event
     * @return void
     */
    public function handle(UserAuditType $event)
    {
        $user_audit = new UserAudit();
        $user_audit->action = $event->action;
        $user_audit->user_id = $event->user_id;
        $user_audit->save();
    }
}
