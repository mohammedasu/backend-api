<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\DB;
use App\Repositories\CmeRepository;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CustomErrorException;

class CmeService
{
    public function __construct()
    {
        $this->repository                   = new CmeRepository();
        $this->cmeMapService                = new CmeMapService();
        $this->masterService                = new MasterService();
        $this->questionBankService          = new QuestionBankService();
        $this->questionBankMapService       = new QuestionBankMapService();
        $this->registrationTemplateService  = new RegistrationTemplateService();
    }

    /**
     * Function to fetch CME list
     */

    public function getAll($request)
    {
        Log::info('CmeService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (\Exception $e) {
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to store CME details
     */

    public function store($request)
    {
        Log::info('CmeService | store', $request->all());
        try {
            DB::beginTransaction();
            $params = $this->CreateRequest($request);
            if ($request->hasFile('landing_page_image')) {
                $fileName = ImageHelper::storeImage($request->file('landing_page_image'), 'cme', null, true, 's3');
                $params['landing_page_image'] = $fileName;
            }
            if ($request->hasFile('survey_background_image')) {
                $fileName = ImageHelper::storeImage($request->file('survey_background_image'), 'cme', null, true, 's3');
                $params['survey_background_image'] = $fileName;
            }
            if ($request->hasFile('survey_background_mobile_image')) {
                $fileName = ImageHelper::storeImage($request->file('survey_background_mobile_image'), 'cme', null, true, 's3');
                $params['survey_background_mobile_image'] = $fileName;
            }
            if ($request->hasFile('pass_image')) {
                $fileName = ImageHelper::storeImage($request->file('pass_image'), 'cme', null, true, 's3');
                $params['pass_image'] = $fileName;
            }
            if ($request->hasFile('fail_image')) {
                $fileName = ImageHelper::storeImage($request->file('fail_image'), 'cme', null, true, 's3');
                $params['fail_image'] = $fileName;
            }
            if ($request->allowed_members_from == 'csv' && $request->hasFile('members_csv_file')) {
                $fileName = ImageHelper::storeImage($request->file('members_csv_file'), 'cme', null, true, 's3');
                $params['members_csv_file'] = $fileName;
            }
            $cme = $this->repository->store($params);
            $questions = $this->questionBankService->storeMultiple(json_decode($request->questions, true));
            $this->questionBankMapService->store($questions, 'cme', $cme->id);
            $this->cmeMapService->store(json_decode($request->attachments, true), $cme->id);
            DB::commit();
            return $cme;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to store CME details
     */

    public function update($request, $cme)
    {
        Log::info('CmeService | update', $request->all());
        try {
            DB::beginTransaction();
            $params = $this->CreateRequest($request);
            if ($request->hasFile('landing_page_image')) {
                if ($cme->landing_page_image) {
                    ImageHelper::destroyImage($cme->landing_page_image, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('landing_page_image'), 'cme', null, true, 's3');
                $params['landing_page_image'] = $fileName;
            }
            if ($request->hasFile('survey_background_image')) {
                if ($cme->survey_background_image) {
                    ImageHelper::destroyImage($cme->survey_background_image, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('survey_background_image'), 'cme', null, true, 's3');
                $params['survey_background_image'] = $fileName;
            }
            if ($request->hasFile('survey_background_mobile_image')) {
                if ($cme->survey_background_mobile_image) {
                    ImageHelper::destroyImage($cme->survey_background_mobile_image, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('survey_background_mobile_image'), 'cme', null, true, 's3');
                $params['survey_background_mobile_image'] = $fileName;
            }
            if ($request->hasFile('pass_image')) {
                if ($cme->pass_image) {
                    ImageHelper::destroyImage($cme->pass_image, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('pass_image'), 'cme', null, true, 's3');
                $params['pass_image'] = $fileName;
            }
            if ($request->hasFile('fail_image')) {
                if ($cme->fail_image) {
                    ImageHelper::destroyImage($cme->fail_image, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('fail_image'), 'cme', null, true, 's3');
                $params['fail_image'] = $fileName;
            }
            if ($request->allowed_members_from == 'data_filter') {
                if ($cme->members_csv_file) {
                    ImageHelper::destroyImage($cme->members_csv_file, 'cme', 's3');
                    $params['members_csv_file'] = null;
                }
            }
            if ($request->allowed_members_from == 'csv' && $request->hasFile('members_csv_file')) {
                if ($cme->members_csv_file) {
                    ImageHelper::destroyImage($cme->members_csv_file, 'cme', 's3');
                }
                $fileName = ImageHelper::storeImage($request->file('members_csv_file'), 'cme', null, true, 's3');
                $params['members_csv_file'] = $fileName;
            }

            $cme = $this->repository->update($params, $cme);
            $this->questionBankMapService->update(json_decode($request->questions, true), 'cme', $cme->id);
            $this->cmeMapService->update(json_decode($request->attachments, true), $cme->id);
            DB::commit();
            return $cme;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomErrorException($e);
        }
    }

    /**
     * Function to store CME details
     */

    public function CreateRequest($request)
    {
        return [
            'type'                      => $request->type,
            'name'                      => $request->name,
            'points'                    => $request->points,
            'description'               => $request->description,
            'heading_text'              => $request->heading_text,
            'survey_url'                => $request->survey_url,
            'passing_criteria'          => $request->passing_criteria,
            'pass_text'                 => $request->pass_text,
            'pass_button_text'          => $request->pass_button_text,
            'fail_text'                 => $request->fail_text,
            'fail_button_text'          => $request->fail_button_text,
            'show_landing_page'         => $request->show_landing_page ? 1 : 0,
            'show_result'               => $request->show_result ? 1 : 0,
            'allow_back'                => $request->allow_back ? 1 : 0,
            'allow_retest'              => $request->allow_retest ? 1 : 0,
            'download_certificate'      => $request->download_certificate ? 1 : 0,
            'certificate_template_id'   => $request->certificate_template_id ? $request->certificate_template_id : null,
            'status'                    => $request->status ? 1 : 0,
            'timer_status'              => $request->timer_status ? $request->timer_status : 0, // 0 => inactive, 1 => on module, 3 => on questions
            'time_in_seconds'           => $request->time_in_seconds ? $request->time_in_seconds : 0,
            'negative_marks_status'     => $request->negative_marks_status ? 1 : 0,
            'negative_mark'             => $request->negative_mark ? $request->negative_mark : 0,
            'positive_mark'             => $request->positive_mark ? $request->positive_mark : 0,
            'registration_template_id'  => $request->registration_template_id,
            'coins'                     => $request->coins ? $request->coins : 0,
            'coins_type'                => $request->coins_type ? $request->coins_type : 'coin',
            'landing_page_button_text'  => $request->landing_page_button_text,
            'show_rand_questions'       => $request->show_rand_questions ? 1 : 0,
            'allowed_members_from'      => $request->allowed_members_from,
            'data_filter_id'            => $request->data_filter_id ? $request->data_filter_id : null,
        ];
    }

    /**
     * Function to store CME details
     */
    public function destroy($cme)
    {
        Log::info('CmeService | destroy');
        try {
            DB::beginTransaction();
            $this->repository->destroy($cme);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomErrorException($e);
        }
    }

    public function updateStatus($request)
    {
        Log::info('CmeService | updateStatus', $request->all());
        $params = ['status' => $request->status];
        $where = ['id' => $request->id];
        $this->repository->updateWithTrashed($where, $params);
    }
}
