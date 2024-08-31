<?php

namespace App\Services;

use App;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomErrorException;
use App\Helpers\CommonHelper;
use App\Helpers\CommunityHelper;
use App\Helpers\ImageHelper;
use App\Models\CaseItems;
use App\Repositories\CaseRepository;
use App\Services\CommunityMapService;
use App\Services\CommunityService;
use App\Services\CaseItemService;
use App\Services\CaseQuestionService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CaseService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new CaseRepository();
        $this->community_map_service = new CommunityMapService();
        $this->case_item_service = new CaseItemService();
        $this->case_question_service = new CaseQuestionService();
        $this->community_service = new CommunityService();
        $this->knowledge_category_item_service = new KnowledgeCategoryItemService();
    }

    /**
     * Function to fetch Case list
     * @param $request
     */

    public function getCases($request)
    {
        Log::info('CaseService | getCases', $request->all());

        $orderBy = ['created_at', 'desc'];
        $data = $this->repository->getAll($request,$orderBy);
        if(!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching Cases.', 500);
        }

        return $data;
    }

    /**
     * Function to show Case
     * @param $request
     */

    public function show($id)
    {
        Log::info('CaseService | show', ['id' => $id]);

        $where = ['id' => $id];
        $data = $this->repository->fetch($where);
        if(!$data) {
            throw new CustomErrorException(null, 'Something Went Wrong in Fetching Case.', 500);
        }

        return $data;
    }

    /**
     * Function to store Case details
     * @param $request
     */

    public function store($request)
    {
        Log::info('CaseService | store', $request->all());

        try {
            DB::beginTransaction();

            $case_count = $this->repository->findWithTodayDate($request->id);
            $case_link_id = 'case' . $case_count . Carbon::now()->format('dmY');

            $params = $this->caseRequest($request);
            $params['translation'] = $request->translation;
            $image = [];
            if ($request->hasFile('image_name_indonesia')) {
                foreach ($request->file('image_name_indonesia') as $file) {
                    $fileName = ImageHelper::storeImage($file, 'cases', 'image_name_indonesia', false, 's3');
                    array_push($image,$fileName);
                }
                //$fileName = ImageHelper::storeImage($params['image_name_indonesia'], 'video', 'image_name_indonesia', true, 's3');

                if(!empty($request->translation)){
                    $trans = json_decode($request->translation, true);
                    $trans['indonesia']['image'] = $image;
                    $params['translation'] = json_encode($trans);
                }
            }

            $sub_specialities = !empty($request->sub_specialities) ? $request->sub_specialities : [];
            $params['link_id'] = $case_link_id;

            $case = $this->repository->create($params);
            if(!$case) {
                throw new CustomErrorException(null, 'Something went wrong with storing case', 500);
            }

            $request['id'] = $case->id;
            $communities_selected = $request->community_selected;

            if (empty($communities_selected)) {
                $request['nopagination'] = 1;
                $request['filter'] = 'active';
                $communities_selected = $this->community_service->fetchAll($request)->pluck('id')->toArray();
            }

            Log::info(['SubSpecialities selected' => $sub_specialities]);

            CommonHelper::storeSubSpecialities($sub_specialities, $case->id, 'cases', false);
            CommunityHelper::storeCommunity($communities_selected, $case->id, 'cases');
            $request['id'] = $case->id;
            $request['type'] = 'cases';
            $this->knowledge_category_item_service->store($request);

            if($request->hasFile('images')) { 
                foreach ($request->file('images') as $file) {
                    //todo : remove this. Added storing in storage till people update their app
                    //$fileName = ImageHelper::storeImage($request->file('images'), 'cases','images', false);
                    $fileName = ImageHelper::storeImage($file, 'cases', 'images', false, 's3');
                    if ($fileName) {
                        $image_params = [
                            'image_name' => $fileName,
                            'case_id' => $case->id,
                            'ip_address' => $request->ip()
                        ];

                        $this->case_item_service->store($image_params);
                    }
                }
            }

            if ($request->question_type == 'mcq') {
                $this->case_question_service->store($request);
            }

            DB::commit();

            return $case;

        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            throw new CustomErrorException($e, 'Something went wrong with storing case');
        }
    }

    public function fetchCase($case_id) {
        $translation = null;
        $fetchCase = $this->repository->fetch(['id' => $case_id]);
        if(!empty($fetchCase)) {
            if(!empty($fetchCase->translation)){
                $translation = json_decode($fetchCase->translation, true);
            }
        }
        return $translation;
    }

    /**
     * Function to update Case details
     * @param $request
     */

    public function update($request)
    {
        Log::info('CaseService | update', $request->all());

        try {
            DB::beginTransaction();
            $params = $this->caseRequest($request);
            $params['translation'] = $request->translation;
            if ($request->hasFile('image_name_indonesia')) {
                $translation = $this->fetchCase($request->id);
                if(isset($translation['indonesia']['image']) && !empty($translation['indonesia']['image'])) {
                    foreach ($translation['indonesia']['image'] as $key => $value) {
                        ImageHelper::destroyImage($value, 'cases', 's3');
                    }
                }

                $image = [];
                foreach ($request->file('image_name_indonesia') as $file) {
                    $fileName = ImageHelper::storeImage($file, 'cases', 'image_name_indonesia', false, 's3');
                    array_push($image,$fileName);
                }

                if(!empty($request->translation)){
                    $trans = json_decode($request->translation, true);
                    $trans['indonesia']['image'] = $image;
                    $params['translation'] = json_encode($trans);
                }
            } else {
                $translation = $this->fetchCase($request->id);
                if(!empty($translation) && isset($translation['indonesia']['image']) && !empty($translation['indonesia']['image'])) {
                    $trans = json_decode($request->translation, true);
                    $trans['indonesia']['image'] = $translation['indonesia']['image'];
                    $params['translation'] = json_encode($trans);
                }
            }

            //$sub_specialities = !empty($request->sub_specialities) ? json_decode($request->sub_specialities) : [];
            $sub_specialities = !empty($request->sub_specialities) ? $request->sub_specialities : [];
            $where = ['id' => $request->id];
            unset($params['created_from']);
            unset($params['created_by']);
            
            $case = $this->repository->updateWithTrashed($where,$params);
            if(!$case) {
                throw new CustomErrorException(null, 'Case updation failed', 500);
            }

            $communities_selected = $request->community_selected;

            Log::info(['SubSpecialities selected' => $sub_specialities]);

            CommonHelper::storeSubSpecialities($sub_specialities, $case->id, 'cases', true);

            CommunityHelper::deleteCommunity($case->id, 'cases');
            CommunityHelper::storeCommunity($communities_selected, $case->id, 'cases');

            $request['id'] = $case->id;
            $request['type'] = 'cases';
            $this->knowledge_category_item_service->destroy($request);
            $this->knowledge_category_item_service->store($request);

            if($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    //todo : remove this. Added storing in storage till people update their app
                    //$fileName = ImageHelper::storeImage($request->file('images'), 'cases','images', false);
                    $fileName = ImageHelper::storeImage($file, 'cases', 'images', false, 's3');
                    if ($fileName) {
                        $image_params = [
                            'image_name' => $fileName,
                            'case_id' => $case->id,
                            'ip_address' => $request->ip()
                        ];

                        $this->case_item_service->store($image_params);
                    }
                }
            }

            if ($request->question_type == 'mcq') {
                $this->case_question_service->update($request);
            }
            DB::commit();
            return $case;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            throw new CustomErrorException($e, 'Something went wrong with updating case');
        }
    }

    public function updateStatus($request)
    {
        Log::info('CaseService | updateStatus', $request->all());
        $params = ['is_active' => $request->is_active, 'ip_address' => $request->ip()];
        $where = ['id' => $request->id];
        
        $case = $this->repository->updateWithTrashed($where,$params);
    }

    /**
     * Function to destroy Case details
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        Log::info('CaseService | destroy', (array)$id);
        try {
            DB::beginTransaction();

            $where = ['id' => $id];
            $case = $this->repository->findwithTrash($id);
            if(!empty($case)){

                // $this->case_item_service->destroy($id);
                // $this->case_question_service->destroy($id);

                if($case->trashed()) {
                    $case = $this->repository->restore($case);
                } else {
                    $case = $this->repository->destroy($where);
                }
            }
            DB::commit();
            return $case;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e);
            throw new CustomErrorException($e, 'Something went wrong with deleting case');
        }
        
    }

    public function caseRequest($request) {
        return  [
            'title' => $request->title,
            'description' => $request->description,
            'expert_id' => $request->expert_id,
            'community_id' => null,
            'question_type' => $request->question_type,
            'partner_division_id' => ($request->partner_division_id ? $request->partner_division_id : null),
            'view_multiplication_factor' => $request->view_multiplication_factor,
            'ip_address' => $request->ip(),
            'meta_title' => $request->meta_title,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
            'country'       => !empty($request->country) ? json_encode($request->country) : null,
            'tags'          => !empty($request->tags) ? json_encode($request->tags) : null,
            'created_from' => 'admin',
            'created_by'    => auth('api')->user()->id
        ];
    }

    public function download($case_id)
    {
        $case_images = CaseItems::select('image_name')->where([
            ['case_id', '=', $case_id]
        ])->get();
        if ($case_images->isEmpty()){
            return false;
        }
        return ImageHelper::downloadZip($case_images, 'cases', 'case_images');
    }
}
