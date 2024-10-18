<?php

namespace App\Listeners;

use App\Events\RegisteredAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\CommentHistoryService;
use App\Services\FirestoreService;

class CreateUserFirestore
{
    private FirestoreService $firestoreService;

    /**
     * Create the event listener.
     */
    public function __construct(FirestoreService $firestoreService)
    {
        $this->firestoreService = $firestoreService;
    }

    /**
     * Handle the event.
     */
    public function handle(RegisteredAccount $event): void
    {
        $user = $event->getAccount();
        $uid = $user->getKey();
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => 'avatar',
            'status' => 'off',
        ];

        $this->firestoreService->addUser($uid, $userData);
    }
}
