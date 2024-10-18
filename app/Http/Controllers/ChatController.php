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
    // Thêm người dùng mới
    public function addUser(Request $request)
    {
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'avatar' => $request->input('avatar'),
            'status' => 'offline',
        ];

        $this->firestore->addUser($userData);

        return response()->json(['status' => 'User added']);
    }

    // Tạo phòng chat mới
    public function createChatRoom(Request $request)
    {
        $chatRoomData = [
            'name' => $request->input('name'),
            'participants' => $request->input('participants'), // mảng userId
            'type' => $request->input('type', 'group'), // loại phòng chat (group hoặc direct)
            'createdAt' => now(),
        ];

        $chatRoom = $this->firestore->createChatRoom($chatRoomData);

        return response()->json(['status' => 'Chat room created', 'chatRoomId' => $chatRoom->id()]);
    }

    // Thêm tin nhắn vào phòng chat
    public function addMessage(Request $request, $chatRoomId)
    {
        $messageData = [
            'sender' => $request->input('sender'),
            'message' => $request->input('message'),
            'timestamp' => now(),
            'isRead' => false,
        ];

        $this->firestore->addMessage($chatRoomId, $messageData);

        return response()->json(['status' => 'Message sent']);
    }

    // Lấy danh sách tin nhắn của phòng chat
    public function getMessages($chatRoomId)
    {
        $messages = $this->firestore->getMessages($chatRoomId);
        $formattedMessages = [];

        foreach ($messages as $message) {
            $formattedMessages[] = $message->data();
        }

        return response()->json($formattedMessages);
    }

    // Lấy thông tin phòng chat
    public function getChatRoom($chatRoomId)
    {
        $chatRoom = $this->firestore->getChatRoom($chatRoomId);
        if ($chatRoom->exists()) {
            return response()->json($chatRoom->data());
        } else {
            return response()->json(['error' => 'Chat room not found'], 404);
        }
    }

    // API để xóa tin nhắn
    public function deleteMessage($chatRoomId, $messageId)
    {
        // Xóa tin nhắn khỏi Firestore
        $this->firestore->deleteMessage($chatRoomId, $messageId);

        return response()->json(['status' => 'Message deleted']);
    }

    // API để lấy danh sách các phòng chat mà người dùng tham gia
    public function getUserChatRooms($userId)
    {
        $chatRooms = $this->firestore->getUserChatRooms($userId);
        $formattedChatRooms = [];

        foreach ($chatRooms as $chatRoom) {
            $formattedChatRooms[] = [
                'id' => $chatRoom->id(),
                'name' => $chatRoom->data()['name'],
                'participants' => $chatRoom->data()['participants'],
                'type' => $chatRoom->data()['type'],
                'createdAt' => $chatRoom->data()['createdAt']
            ];
        }

        return response()->json($formattedChatRooms);
    }
}
