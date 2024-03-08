<?php

namespace App\Services;

use App\Models\Question;
use App\Repositories\QuestionRepository;

class QuestionService
{
    protected QuestionRepository $repository;

    public function __construct(QuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attrs): Question
    {
        $question = $this->repository->create($attrs);

        /** @var TagService $tagService */
        $tagService = app(TagService::class);
        $tagsSaved = $tagService->insert($attrs['tags']);
        $tagService->attach($question, $tagsSaved);

        return $question;
    }

    public function update(Question $question, array $attrs): Question
    {
        $question = $this->repository->update($attrs, $question->getKey());

        /** @var TagService $tagService */
        $tagService = app(TagService::class);
        $tagsSaved = $tagService->insert($attrs['tags']);
        $tagService->sync($question, $tagsSaved);

        return $question;
    }

    public function delete(Question $question): void
    {
        $question->delete();
    }
}
