<?php

namespace App\Services;

use App;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuestionReferenceRepository;

class QuestionReferenceService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new QuestionReferenceRepository();
    }

    /**
     * Function to fetch all question reference detail list
    */

    public function getAll($request)
    {
        Log::info('QuestionReferenceService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }
}
