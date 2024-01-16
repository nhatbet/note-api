<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vote;
use App\Repositories\VoteRepository;
use Illuminate\Database\Eloquent\Model;

class VoteService
{
    protected VoteRepository $repository;

    public function __construct(VoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function up(Vote $vote): Vote
    {
        $vote = $this->repository->update(['value' => Vote::UP], $vote->getKey());

        return $vote;
    }

    public function down(Vote $vote): Vote
    {
        $vote = $this->repository->update(['value' => Vote::DOWN], $vote->getKey());

        return $vote;
    }

    public function reset(Vote $vote): Vote
    {
        $vote = $this->repository->update(['value' => Vote::RESET], $vote->getKey());

        return $vote;
    }

    public function findVote(User $voter, Model $model): Vote
    {
        $vote = $this->repository->firstOrCreate([
            'voter_id' => $voter->getKey(),
            'voteable_id' => $model->getKey(),
            'voteable_type' => get_class($model),
        ]);

        return $vote;
    }
}
