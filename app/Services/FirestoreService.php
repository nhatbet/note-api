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

    // Thêm người dùng với UID tùy chỉnh
    public function addUser($uid, $userData)
    {
        $database = $this->firestore->database();

        $userRef = $database->collection('users')->document($uid);

        return $userRef->set($userData);
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

    // Lấy tất cả phòng chat mà người dùng tham gia với phân trang
    public function getUserChatRooms($userId, $limit = 10, $startAfter = null)
    {
        $database = $this->firestore->database();
        $chatRoomsRef = $database->collection('chatRooms');
        $query = $chatRoomsRef->where('participants', 'array-contains', $userId)
            // ->orderBy(fieldPath: 'createdAt', direction: 'desc') // sắp xếp theo thời gian tạo
            ->limit($limit);

        // Nếu có `startAfter`, thêm điều kiện để phân trang
        if ($startAfter) {
            $lastSnapshot = $chatRoomsRef->document($startAfter)->snapshot();
            $query = $query->startAfter($lastSnapshot);
        }

        return $query->documents();
    }
}
