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
        // $uid = $request->input('uid');
        $uid = 1;
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'avatar' => $request->input('avatar'),
            'status' => 'off',
        ];
        // Thêm người dùng với UID cụ thể
        $this->firestore->addUser($uid, $userData);

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

    // API để lấy danh sách các phòng chat mà người dùng tham gia với phân trang
    public function getUserChatRooms(Request $request, $userId)
    {
        // Lấy tham số limit và startAfter từ request
        $limit = $request->input('limit', 10); // số lượng phòng chat trên mỗi trang
        $startAfter = $request->input('startAfter'); // ID của tài liệu bắt đầu trang tiếp theo

        // Lấy danh sách phòng chat
        $chatRooms = $this->firestore->getUserChatRooms($userId, $limit, $startAfter);
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

        // Xác định phòng chat cuối cùng để phục vụ phân trang
        $lastChatRoom = end($formattedChatRooms);
        $nextPageToken = $lastChatRoom ? $lastChatRoom['id'] : null;

        return response()->json([
            'chatRooms' => $formattedChatRooms,
            'nextPageToken' => $nextPageToken // ID của phòng chat cuối để phân trang
        ]);
    }

    // API để thêm phản ứng vào tin nhắn
    public function addReaction(Request $request, $chatRoomId, $messageId)
    {
        $emoji = $request->input('emoji'); // Biểu tượng cảm xúc
        $userId = $request->input('userId'); // ID của người dùng

        $this->firestore->addReaction($chatRoomId, $messageId, $emoji, $userId);
        return response()->json(['status' => 'Reaction added']);
    }

    // API để xóa phản ứng khỏi tin nhắn
    public function removeReaction(Request $request, $chatRoomId, $messageId)
    {
        $emoji = $request->input('emoji'); // Biểu tượng cảm xúc
        $userId = $request->input('userId'); // ID của người dùng

        $this->firestore->removeReaction($chatRoomId, $messageId, $emoji, $userId);
        return response()->json(['status' => 'Reaction removed']);
    }
}
