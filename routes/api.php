<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\SocialiteLoginController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;

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
Route::post('register', [AuthController::class, 'register']);

Route::get('url-sign-in/google', [SocialiteLoginController::class, 'googleSignInUrl']);
Route::get('login/google/callback', [SocialiteLoginController::class, 'googleCallback']);

Route::middleware(['auth:sanctum', 'ability:issue-access-token'])->group(function () {
    Route::get('auth/refresh-token', [AuthController::class, 'refreshToken']);
});

// Route for auth
Route::middleware(['auth:sanctum', 'ability:access-api'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // CRUD Article
    Route::get('articles', [ArticleController::class, 'index']);
    Route::post('articles', [ArticleController::class, 'store']);
    Route::put('articles/{article}', [ArticleController::class, 'update']);
    Route::delete('articles/{article}', [ArticleController::class, 'destroy']);

    // Vote article
    Route::post('articles/{article}/up-vote', [ArticleController::class, 'upVote']);
    Route::post('articles/{article}/down-vote', [ArticleController::class, 'downVote']);
    Route::post('articles/{article}/reset-vote', [ArticleController::class, 'resetVote']);

    // Report article
    Route::post('articles/{article}/report', [ReportController::class, 'createForArticle']);

    // Comment article
    Route::post('articles/{article}/comments', [CommentController::class, 'createForArticle']);

    // Comment
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('comments/{comment}/report', [ReportController::class, 'createForComment']);
});

// test
Route::middleware(['auth:sanctum', 'ability:access-api'])->get('/user', function (Request $request) {
    return $request->user();
});
