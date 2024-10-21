<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function upload(Request $request): JsonResponse
    {
        $user = $request->user();
        $collection = $request->get('collection');
        if ($collection === 'avatar') {
            $user->clearMediaCollection('avatar');
        }
        // $file = $request->file('file');
        // $media = $user->addMedia($file)->toMediaCollection($collection);

        $media = $user->addMediaFromRequest('file')->toMediaCollection($collection);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $media
        ]);
    }
}
