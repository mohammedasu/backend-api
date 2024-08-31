<?php

namespace App\Services;

use App;
use Illuminate\Support\Facades\Log;
use App\Repositories\ForumRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Helpers\CommonHelper;
use App\Helpers\ForumHelper;
use App\Helpers\CommunityHelper;

class ForumService
{
    protected $repository;
    protected $community_map_service;


    public function __construct()
    {
        $this->repository = new ForumRepository();
    }

    public function getAll($request)
    {
        Log::info('ForumService | getAll');
        $filter = null;
        $search = null;
        if ($request->filter) {
            $filter = $request->filter;
        }
        if ($request->search) {
            $search = $request->search;
        }
        return $this->repository->getAll($request, $filter,$search);
    }

    public function store($params)
    {
        Log::info('ForumService | store', $params);
        

        try {
            DB::beginTransaction();
            $params = ForumHelper::createParams($params);

            $council_experts = isset($params['council_experts']) ? json_decode($params['council_experts']) : [];
            $other_experts = isset($params['other_experts']) ? json_decode($params['other_experts']) : [];
            $community_selected = isset($params['community']) ? json_decode($params['community']) : [];
            $sub_specialities = isset($params['sub_specialities']) ? json_decode($params['sub_specialities']) : [];

            $params_send_private['privacy_rule'] = isset($params['privacy_rule']) ? json_decode($params['privacy_rule']) : [];
            $params_send_private['rule_type_password'] = $params['rule_type_password'] ?? null;
            $params_send_private['invitation_file'] = $params['invitation_file'] ?? null;
            $params_send_private['forum_visibility'] = $params['forum_visibility'];

            $params = ForumHelper::unsetParams($params);
            $params['created_from']     = 'admin';
            $params['created_by']        = auth('api')->user()->id;
            $forum_data = $this->repository->create($params);
            $forum_id = $forum_data->id;
            if ($params['forum_visibility'] == 'public' && is_array($community_selected)) {

                CommunityHelper::storeCommunity($community_selected, $forum_id, 'partner_division');
            }
            if (is_array($sub_specialities)) {
                CommonHelper::storeSubSpecialities($sub_specialities, $forum_id, 'partner_division', false);
            }
            if ($council_experts && is_array($council_experts)) {
                CommonHelper::storeExpertMap($council_experts, $forum_id, 'forum_council_expert');
            }
            if ($other_experts && is_array($other_experts)) {
                CommonHelper::storeExpertMap($other_experts, $forum_id, 'forum_other_expert');
            }


            ForumHelper::PrivateInvitationImport($params_send_private, $forum_data);

            DB::commit();
            return $forum_data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }
    }
    public function update($params)
    {
        Log::info('ForumService | update', $params);
        try {
            DB::beginTransaction();
            $forum_id = $params['forum_id'];
            $params = ForumHelper::createParams($params);

            $council_experts = isset($params['council_experts']) ? json_decode($params['council_experts']) : [];
            $other_experts = isset($params['other_experts']) ? json_decode($params['other_experts']) : [];
            $community_selected = isset($params['community']) ? json_decode($params['community']) : [];
            $sub_specialities = isset($params['sub_specialities']) ? json_decode($params['sub_specialities']) : [];

            $params_send_private['privacy_rule'] = isset($params['privacy_rule']) ? json_decode($params['privacy_rule']) : [];
            $params_send_private['rule_type_password'] = $params['rule_type_password'] ?? null;
            $params_send_private['invitation_file'] = $params['invitation_file'] ?? null;
            $params_send_private['forum_visibility'] = $params['forum_visibility'];

            $params = ForumHelper::unsetParams($params);
            unset($params['forum_id']);

            $cta_data = json_decode($params['cta_data']);
            $params['cta_data'] = $cta_data;

            $forum_tabs = json_decode($params['forum_tabs']);
            $params['forum_tabs'] = $forum_tabs;

            

            $forum_data = $this->repository->updateWithTrashed($params, ['id' => $forum_id]);

            if ($params['forum_visibility'] == 'public' && is_array($community_selected)) {

                CommunityHelper::deleteCommunity($forum_id, 'partner_division');
                CommunityHelper::storeCommunity($community_selected, $forum_id, 'partner_division');
            }
            if (is_array($sub_specialities)) {
                CommonHelper::storeSubSpecialities($sub_specialities, $forum_id, 'partner_division', true);
            }
            if (is_array($council_experts)) {
                CommonHelper::storeExpertMap($council_experts, $forum_id, 'forum_council_expert');
            }
            if (is_array($other_experts)) {
                CommonHelper::storeExpertMap($other_experts, $forum_id, 'forum_other_expert');
            }

            ForumHelper::PrivateInvitationImport($params_send_private, $forum_data);

            DB::commit();
            return $forum_data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }
    }
    public function updateStatus($params)
    {
        Log::info('ForumService | updateStatus', $params);
        $params_update['is_active'] = !empty($params['is_active']) ? $params['is_active'] : 0;
        return $this->repository->updateWithTrashed($params_update, ['id' => $params['id']]);
    }
    public function destroy($params)
    {
        Log::info('ForumService | destroy', $params);
        $params_update['is_active'] = 0;
        $params_update['id'] = $params['id'];
        $this->updateStatus($params_update);
        return $this->repository->destroy(['id' => $params['id']]);
    }
    public function show($params)
    {
        Log::info('ForumService | show', $params);
        if(isset($params['link_name'])) {
            return $this->repository->findByMultipleFields(['link_name' => $params['id']]);
        } else {
            return $this->repository->findByMultipleFields(['id' => $params['id']]);
        }
        // return $this->repository->findByMultipleFields(['id' => $params['id']]);
    }
    public function restore($params)
    {
        Log::info('ForumService | restore', $params);
        return $this->repository->restore(['id' => $params['id']]);
    }
}
