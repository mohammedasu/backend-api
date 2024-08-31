<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\CaseItemRepository;
use Illuminate\Support\Facades\Log;

class CaseItemService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new CaseItemRepository();
    }

    /**
     * Function to store Role details
     * @param $request
     */

    public function store($request)
    {
        Log::info('CaseItemService | store', $request);

        return $this->repository->create($request);
    }

    public function destroy($id)
    {
        Log::info('CaseItemService | destroy', (array)$id);

        $where = ['case_id' => $id];
        $case_items = $this->repository->getAll($where);
        if ($case_items->isNotEmpty()) {
            foreach ($case_items as $value) {
                ImageHelper::destroyImage($value->image_name, 'cases/', 's3');
            }
        }
        return $this->repository->destroy($where);
    }

    public function destroySingleImage($itemId)
    {
        Log::info('CaseItemService | destroySingleImage', (array)$itemId);

        $where = ['id' => $itemId];
        $caseItem = $this->repository->fetchOne($where);
        if ($caseItem) {
            ImageHelper::destroyImage($caseItem->image_name, 'cases/', 's3');
        }
        return $this->repository->destroy($where);
    }
}
