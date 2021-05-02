<?php

namespace App\Providers;

use App\Events\FileDownloadUpload;
use App\Events\UserAuditType;
use App\Listeners\SaveFileAudit;
use App\Listeners\SaveUserAudit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        FileDownloadUpload::class => [
            SaveFileAudit::class,
        ],
        UserAuditType::class => [
            SaveUserAudit::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
