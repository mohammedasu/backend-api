<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use App\Repositories\QuizRepository;
use Illuminate\Support\Facades\Log;

class QuizService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new QuizRepository();
    }

    public function getAll($request) {
        Log::info('QuizService | getAll', $request->all());

        return $this->repository->getAll($request);
    }
}
