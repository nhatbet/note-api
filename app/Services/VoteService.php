<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vote;
use App\Repositories\VoteRepository;
use Illuminate\Database\Eloquent\Model;

class VoteService
{
    public function up(Vote $vote): Vote
    {
        /** @var VoteRepository $voteRepo */
        $voteRepo = app(VoteRepository::class);
        $vote = $voteRepo->update(['value' => 1], $vote->getKey());

        return $vote;
    }

    public function down(Vote $vote): Vote
    {
        /** @var VoteRepository $voteRepo */
        $voteRepo = app(VoteRepository::class);
        $vote = $voteRepo->update(['value' => -1], $vote->getKey());

        return $vote;
    }

    public function reset(Vote $vote): Vote
    {
        /** @var VoteRepository $voteRepo */
        $voteRepo = app(VoteRepository::class);
        $vote = $voteRepo->update(['value' => 0], $vote->getKey());

        return $vote;
    }

    public function findVote(User $voter, Model $model): Vote
    {
        /** @var VoteRepository $voteRepo */
        $voteRepo = app(VoteRepository::class);

        $vote = $voteRepo->firstOrCreate([
            'voter_id' => $voter->getKey(),
            'voteable_id' => $model->getKey(),
            'voteable_type' => get_class($model),
        ]);

        return $vote;
    }
}
