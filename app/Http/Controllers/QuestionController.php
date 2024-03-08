<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;
use App\Models\Question;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Requests\Question\UpdateRequest;

class QuestionController extends Controller
{
    protected QuestionService $service;

    public function __construct(QuestionService $service)
    {
        $this->service = $service;
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $question = $this->service->store($request->validated() + ['questioner_id' => $request->user()->getKey()]);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $question
        ]);
    }

    public function update(UpdateRequest $request, Question $question): JsonResponse
    {
        $question = $this->service->update($question, $request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => $question
        ]);
    }

    public function destroy(Question $question): JsonResponse
    {
        $this->service->delete($question);

        return response()->json([
            'status' => 200,
            'message' => 'ok',
            'data' => null
        ]);
    }
}
