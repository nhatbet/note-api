<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\LoggedOut;
use App\Listeners\DeleteDevice;
use App\Events\CommentUpdated;
use App\Events\NotificationCreated;
use App\Listeners\CreateCommentHistory;
use App\Listeners\PushFCM;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        LoggedOut::class => [
            DeleteDevice::class,
        ],
        CommentUpdated::class => [
            CreateCommentHistory::class,
        ],
        NotificationCreated::class => [
            PushFCM::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
