<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\SocialiteLoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DeviceTokenController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SelectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);
Route::post('login/provider', [SocialiteLoginController::class, 'loginWithProvider']);
Route::post('register', [AuthController::class, 'register']);
Route::get('github/callback/', [SocialiteLoginController::class, 'call']);


Route::middleware(['auth:sanctum', 'ability:issue-access-token'])->group(function () {
    Route::get('auth/refresh-token', [AuthController::class, 'refreshToken']);
});

Route::get('device-tokens/send-demo', [DeviceTokenController::class, 'sendDemoToFirstToken']);

Route::get('selection', [SelectionController::class, 'index']);

Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{article}', [ArticleController::class, 'show']);
Route::get('comments/get-by-article', [CommentController::class, 'getByArticle']);
Route::get('comments', [CommentController::class, 'index']);
Route::get('comments/articles-count', [CommentController::class, 'getCountByArticle']);
// Route for auth
Route::middleware(['auth:sanctum', 'ability:access-api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Profile
    Route::get('user/profile', [UserController::class, 'getProfile']);
    Route::post('user/profile', [UserController::class, 'updateProfile']);

    // CRUD Article
    // Route::get('articles', [ArticleController::class, 'index']);
    Route::post('articles', [ArticleController::class, 'store']);
    Route::put('articles/{article}', [ArticleController::class, 'update'])->can('update', 'article');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->can('delete', 'article');
    Route::get('articles/created/by-me', [ArticleController::class, 'getMyArticle']);

    // Vote article
    Route::post('articles/{article}/up-vote', [ArticleController::class, 'upVote']);
    Route::post('articles/{article}/down-vote', [ArticleController::class, 'downVote']);
    Route::post('articles/{article}/reset-vote', [ArticleController::class, 'resetVote']);

    // Report
    Route::post('articles/{article}/report', [ReportController::class, 'createForArticle']);
    Route::post('comments/{comment}/report', [ReportController::class, 'createForComment']);

    // Comment article
    Route::post('articles/{article}/comments', [CommentController::class, 'createForArticle']);

    // Comment
    Route::put('comments/{comment}', [CommentController::class, 'update'])->can('update', 'comment');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->can('delete', 'comment');

    // Save
    // TODO: check permission
    // Route::post('saves/{save}/delete', [SaveController::class, 'unSave'])->can('delete', 'save');
    Route::post('articles/{article}/save', [SaveController::class, 'saveArticle']);
    Route::post('articles/{article}/unsave', [SaveController::class, 'unSaveArticle']);
    Route::get('articles/{article}/save-status', [SaveController::class, 'getByArticle']);
    Route::get('saves', [SaveController::class, 'index']);

    // Question
    Route::post('questions', [QuestionController::class, 'store']);
    Route::put('questions/{question}', [QuestionController::class, 'update'])->can('update', 'question');
    Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->can('delete', 'question');

    // Device
    Route::post('device-tokens', [DeviceTokenController::class, 'store']);

    // Media
    Route::post('upload', [MediaController::class, 'upload']);

    // Chat
    Route::post('chat/users', [ChatController::class, 'addUser']); // Thêm người dùng mới
    Route::post('chat/rooms', [ChatController::class, 'createChatRoom']); // Tạo phòng chat
    Route::post('chat/rooms/{chatRoomId}/messages', [ChatController::class, 'addMessage']); // Thêm tin nhắn vào phòng chat
    Route::get('chat/rooms/{chatRoomId}/messages', [ChatController::class, 'getMessages']); // Lấy tin nhắn của phòng chat
    Route::get('chat/rooms/{chatRoomId}', [ChatController::class, 'getChatRoom']); // Lấy thông tin phòng chat
    Route::delete('chat/rooms/{chatRoomId}/messages/{messageId}', [ChatController::class, 'deleteMessage']); // Xóa tin nhắn trong phòng chat

    Route::get('chat/users/{userId}/chatRooms', [ChatController::class, 'getUserChatRooms']); // Lấy tất cả phòng chat mà user tham gia
    // Thêm phản ứng vào tin nhắn
    Route::post('chat/{chatRoomId}/messages/{messageId}/reactions', [ChatController::class, 'addReaction']);
    // Xóa phản ứng khỏi tin nhắn
    Route::delete('chat/{chatRoomId}/messages/{messageId}/reactions', [ChatController::class, 'removeReaction']);

    Route::get('notifications', [NotificationController::class, 'index']);
    Route::get('notifications/count-not-read-yet', [NotificationController::class, 'countNotReadYet']);

});

// test
Route::middleware(['auth:sanctum', 'ability:access-api'])->get('/user', function (Request $request) {
    return $request->user();
});
