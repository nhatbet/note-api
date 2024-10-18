<?php

namespace App\Services;

use Kreait\Firebase\Contract\Firestore;

class FirestoreService
{
    private Firestore $firestore;

    public function __construct(Firestore $firestore)
    {
        $this->firestore = $firestore;
    }

    public function addMessage($chatRoomId, $message)
    {
        $database = $this->firestore->database();
        $collection = $database->collection('chatRooms')->document($chatRoomId)->collection('messages');
        return $collection->add($message);
    }

    public function getMessages($chatRoomId)
    {
        $database = $this->firestore->database();
        $collection = $database->collection('chatRooms')->document($chatRoomId)->collection('messages');

        return $collection->documents();
    }
}
