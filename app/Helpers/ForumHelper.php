<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Helpers\ImageHelper;
use App\Services\PrivateForumRuleService;
use App\Services\PrivateForumInviteService;
use Illuminate\Support\Facades\DB;
use App\Imports\PrivateForumInviteImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class ForumHelper
{
    public static function unsetParams($params)
    {

        unset($params['council_experts']);
        unset($params['other_experts']);
        unset($params['community']);
        unset($params['sub_specialities']);
        unset($params['privacy_rule']);
        unset($params['rule_type_password']);
        unset($params['invitation_file']);
        return $params;
    }
    public static function createParams($params)
    {
        Log::info('ForumHelper | createParams', $params);

        // no decoding require as data coming as json and we are saving in json 
        if (isset($params['user_types']) && !empty($params['user_types'])) {
            $params['user_types'] = $params['user_types'];
        }
        if (isset($params['forum_manager'])) {
            $params['forum_manager'] = $params['forum_manager'];
        }
        if (isset($params['image_name']) && !empty($params['image_name'])) {
            $fileName = ImageHelper::storeImage($params['image_name'], 'partner', 'image_name', true, 's3');
            $params['image_name'] = $fileName;
        }
        if (isset($params['website_banner_image'])  && !empty($params['website_banner_image'])) {
            $fileName = ImageHelper::storeImage($params['website_banner_image'], 'partner', 'website_banner_image', true, 's3');
            $params['website_banner_image'] = $fileName;
        }
        if (isset($params['pre_login_image']) && !empty($params['pre_login_image'])) {
            $fileName = ImageHelper::storeImage($params['pre_login_image'], 'partner', 'pre_login_image', true, 's3');
            $params['pre_login_image'] = $fileName;
        }

        if (isset($params['pre_login_image2']) && !empty($params['pre_login_image2'])) {
            $fileName = ImageHelper::storeImage($params['pre_login_image2'], 'partner', 'pre_login_image2', true, 's3');
            $params['pre_login_image2'] = $fileName;
        }

        if (isset($params['thumbnail_image']) && !empty($params['thumbnail_image'])) {
            $fileName = ImageHelper::storeImage($params['thumbnail_image'], 'partner', 'thumbnail_image', true, 's3');
            $params['thumbnail_image'] = $fileName;
        }

        if (isset($params['thumbnail_image_logo']) && !empty($params['thumbnail_image_logo'])) {
            $fileName = ImageHelper::storeImage($params['thumbnail_image_logo'], 'partner', 'thumbnail_image_logo', true, 's3');
            $params['thumbnail_image_logo'] = $fileName;
        }

        // coming as json string ,no conversion require here//

        $params['country'] = !empty($params['country']) ? $params['country'] : null;
        $params['state'] = !empty($params['state']) ? $params['state'] : null;
        $params['city'] = !empty($params['city']) ? $params['city'] : null;
        if ($params['is_knowledge_academy_active']) {

            if (isset($params['knowledge_academy_banner_image']) && !empty($params['knowledge_academy_banner_image'])) {
                $fileName = ImageHelper::storeImage($params['knowledge_academy_banner_image'], 'partner', 'knowledge_academy_banner_image', true, 's3');
                $params['knowledge_academy_banner_image'] = $fileName;
            }
            if (isset($params['knowledge_academy_banner_image_mobile']) && !empty($params['knowledge_academy_banner_image_mobile'])) {
                $fileName = ImageHelper::storeImage($params['knowledge_academy_banner_image_mobile'], 'partner', 'knowledge_academy_banner_image_mobile', true, 's3');
                $params['knowledge_academy_banner_image_mobile'] = $fileName;
            }
        }
        return $params;
    }

    public static function PrivateInvitationImport($params, $forum_data)
    {
        Log::info('ForumHelper | PrivateInvitationImport', $params);
        $forum_id = $forum_data->id ?? null;
        $private_forum_rule_id = null;
        $private_forum_rule_service = new PrivateForumRuleService();
        $private_forum_invite_service = new PrivateForumInviteService();

        if ($params['forum_visibility'] == 'private') {


            $private_rules = $forum_data->privacyRules()->get();
            if (count($private_rules) > 0) {
                foreach ($private_rules as $val) {
                    if ($val['rule_type'] == 'invitation') {
                        $private_forum_invite_service->delete([
                            'forum_id' => $forum_id,
                        ]);
                    }
                    $private_forum_rule_service->delete([
                        'forum_id' => $forum_id,
                        'rule_type' => $val['rule_type'],
                    ]);
                }
            }


            foreach ($params['privacy_rule'] as $rule) {
                $rule_action = null;
                // if ($rule == 'invitation') {
                //     $private_forum_invite_service->delete([
                //         'forum_id' => $forum_id,
                //     ]);
                // }
                // delete data  from forum rule
                // $private_forum_rule_service->delete([
                //     'forum_id' => $forum_id,
                //     'rule_type' => $rule,
                // ]);

                if ($rule == 'password') {
                    $rule_action = $params['rule_type_password'];
                }

                $private_forum_rule =  $private_forum_rule_service->store([
                    'forum_id' => $forum_id,
                    'rule_type' => $rule,
                    'rule_action' => $rule_action
                ]);
                if ($rule == 'invitation') {
                    $private_forum_rule_id = $private_forum_rule->id;
                }


                if ($rule == 'invitation') {
                    try {
                        DB::beginTransaction();
                        if (isset($params['invitation_file']) && !empty($params['invitation_file'])) {
                            Excel::import(new PrivateForumInviteImport($private_forum_rule_id, $forum_id), $params['invitation_file']);
                        }
                        DB::commit();
                    } catch (\Exception $e) {
                        throw new Exception($e);
                    }
                }
            }
        }
    }
}
