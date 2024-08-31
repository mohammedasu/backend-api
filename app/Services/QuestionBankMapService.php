<?php

namespace App\Services;

use App\Imports\CmeQuestionImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exceptions\CustomErrorException;
use App\Repositories\QuestionBankMapRepository;

class QuestionBankMapService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new QuestionBankMapRepository();
    }

    /**
     * Function to store question bank mapping data
    */
    public function store($questions,$type,$typeId)
    {
        Log::info('QuestionBankMapService | store', $questions);
        try {
            $params = [];
            foreach($questions as $question){
                $data = $this->CreateRequest($question,$type,$typeId);
                array_push($params,$data);
            }
            return $this->repository->storeMultiple($params);
        }
        catch (\Exception $e){
            throw new CustomErrorException($e);            
        }
    }

    /**
     * Function to update question bank mapping data
    */
    public function update($questions, $type, $typeId)
    {
        Log::info('QuestionBankMapService | update', $questions);
        try {
            $params = [];
            foreach($questions as $question){
                $data = $this->CreateRequest($question,$type,$typeId);
                if(is_null($question['mapped_id'])) {
                    array_push($params, $data);
                }
                else{
                    $this->repository->update($data,$question['mapped_id']);
                }
            }
            return $this->repository->storeMultiple($params);
        }
        catch (\Exception $e){
            throw new CustomErrorException($e);            
        }
    }

    /**
     * Function to create request for add and update
    */
    public function createRequest($question,$type,$typeId)
    {
        return [
            'question_bank_id'      => $question['id'],
            'map_id'                => $typeId,
            'map_type'              => $type,
            'show_answer'           => $question['show_answer'] ? 1 : 0,
            'show_answer_details'   => $question['show_answer_details'] ? 1 : 0
        ];
    }

    /**
     * Function to store CME details
    */
    public function destroy($questionBankMap)
    {
        Log::info('QuestionBankMapService | destroy');
        try {
            $this->repository->destroy($questionBankMap);
            return true;
        } catch (\Exception $e){
            throw new CustomErrorException($e);            
        }
    }

    /**
     * Function to import cme questions
    */
    public function importQuestions($request)
    {
        Log::info('QuestionBankMapService | importQuestions');
        try {
            $data = Excel::toCollection(new CmeQuestionImport, request()->file('csv_file'));
            $newData = [];
            foreach ($data->first() as $key => $value) {
                $newArray = [];
                $newArray['question']         = $value['question'];
                $newArray['type']             = $value['type'];
                $newArray['correct_answer']   = $value['correct_answer'];
                $newArray['is_mandatory']     = $value['is_mandatory'];
                if($value['type'] == 'mcq'){
                    $optionArray = [];
                    for ($i=1; $i <=5 ; $i++) { 
                        $optionArray[] = ['key'=> $i, 'value' => $value['option'.$i]]; 
                    }
                    $newArray['options'] = json_encode($optionArray);
                }
                else{
                    $newArray['options'] = null;
                }
                $newData[] = $newArray;
            }
            return $newData;
        } catch (\Exception $e){
            throw new CustomErrorException($e);            
        }
    }

}
