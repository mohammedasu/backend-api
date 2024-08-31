<?php

namespace App\Services;

use App\Repositories\CmeMapRepository;
use App\Exceptions\CustomErrorException;
use Illuminate\Support\Facades\Log;

class CmeMapService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new CmeMapRepository();
    }

    /**
     * Function to store CME mapping data
     * @param $attachments
     * @param $cmeId
     * @return bool
     */
    public function store($attachments, $cmeId)
    {
        Log::info('CmeMapService | store', $attachments);
        try {
            $params = [];
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $data = $this->createRequest($attachment, $cmeId);
                    array_push($params, $data);
                }
                return $this->repository->storeMultiple($params);
            }
        } catch (\Exception $e) {
            throw new CustomErrorException($e, 'Something went wrong');
        }
    }

    /**
     * Function to update CME mapping data
     * @param $attachments
     * @param $cmeId
     * @return bool
     */
    public function update($attachments, $cmeId): bool
    {
        Log::info('CmeMapService | update', $attachments);
        try {
            $params = [];
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $data = $this->createRequest($attachment, $cmeId);
                    if (is_null($attachment['mapped_id'])) {
                        array_push($params, $data);
                    } else {
                        $this->repository->update($data, $attachment['mapped_id']);
                    }
                }
            }
            return $this->repository->storeMultiple($params);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to create request for add and update
     * @param $question
     * @param $cmeId
     * @return array
     */
    public function createRequest($question, $cmeId): array
    {
        return [
            'cme_id'        => $cmeId,
            'map_type'      => $question['map_type'],
            'map_type_id'   => $question['map_type_id'] ?? 0,
            'when_to_show'  => $question['when_to_show'] ? $question['when_to_show'] : 0,
        ];
    }

    /**
     * Function to store CME details
     * @param $cmeMap
     * @return bool
     */
    public function destroy($cmeMap): bool
    {
        Log::info('CmeMapService | destroy', ['id' => $cmeMap->id]);
        try {
            $this->repository->destroy($cmeMap);
            return true;
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }
}
