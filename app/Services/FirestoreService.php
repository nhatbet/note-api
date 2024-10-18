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

    // Thêm người dùng vào Firestore
    public function addUser($userData)
    {
        $database = $this->firestore->database();

        return $database->collection('users')->add($userData);
    }

    // Tạo phòng chat mới
    public function createChatRoom($chatRoomData)
    {
        $database = $this->firestore->database();

        return $database->collection('chatRooms')->add($chatRoomData);
    }

    // Thêm tin nhắn vào phòng chat
    public function addMessage($chatRoomId, $messageData)
    {
        $database = $this->firestore->database();

        return $database->collection('chatRooms')
            ->document($chatRoomId)
            ->collection('messages')
            ->add($messageData);
    }

    // Lấy danh sách tin nhắn từ phòng chat
    public function getMessages($chatRoomId)
    {
        $database = $this->firestore->database();

        return $database->collection('chatRooms')
            ->document($chatRoomId)
            ->collection('messages')
            ->orderBy('timestamp')
            ->documents();
    }

    // Lấy thông tin phòng chat
    public function getChatRoom($chatRoomId)
    {
        $database = $this->firestore->database();

        return $database->collection('chatRooms')->document($chatRoomId)->snapshot();
    }

    // Xóa tin nhắn trong phòng chat
    public function deleteMessage($chatRoomId, $messageId)
    {
        $database = $this->firestore->database();
        $messageRef = $database->collection('chatRooms')
            ->document($chatRoomId)
            ->collection('messages')
            ->document($messageId);

        $messageRef->delete();

        return true;
    }

    // Lấy tất cả phòng chat mà người dùng tham gia
    public function getUserChatRooms($userId)
    {
        $database = $this->firestore->database();
        $chatRoomsRef = $database->collection('chatRooms');
        $query = $chatRoomsRef->where('participants', 'array-contains', $userId);

        return $query->documents();
    }
}
