<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function upload(Request $request) {
        $collection = $request->get('collection');
        $file = $request->file('file');

        $user = $request->user();
        $media = $user->addMedia($file)->toMediaCollection($collection);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $media
        ]);
    }
}
