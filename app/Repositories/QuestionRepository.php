<?php

namespace App\Repositories;

use App\Models\Question;
use Prettus\Repository\Eloquent\BaseRepository;

class QuestionRepository extends BaseRepository
{
    function model(): string
    {
        return Question::class;
    }
}
