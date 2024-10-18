<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirestoreService;

class ChatController extends Controller
{
    protected $firestore;

    public function __construct(FirestoreService $firestore)
    {
        $this->firestore = $firestore;
    }

    public function addMessage(Request $request, $chatRoomId)
    {
        $message = [
            'sender' => $request->input('sender'),
            'message' => $request->input('message'),
            'timestamp' => now()
        ];

        $this->firestore->addMessage('room_1', $message);
        return response()->json(['status' => 'Message sent']);
    }

    public function getMessages($chatRoomId)
    {
        $messages = $this->firestore->getMessages($chatRoomId);
        return response()->json($messages->toArray());
    }
}
