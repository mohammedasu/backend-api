<?php

namespace App\Helpers;

use App\Repositories\UtmLinkRepository;

class UtmLinkHelper
{

    public static function utmLinkGenerate($linkDetails)
    {
        $utm_link_repository = new UtmLinkRepository();

        $doctorId = $linkDetails["doctor_id"] ?? 0;
        $projectId = $linkDetails["project_id"] ?? 0;
        $digimrId = $linkDetails["digimr_id"] ?? 0;
        $universal_doctor_id = $linkDetails["universal_doctor_id"] ?? 0;
        $utmId = $linkDetails["utm_id"] ?? 0;
        $utmCampaign = $linkDetails["utm_campaign"] ?? "";
        $utmContentType = $linkDetails["content_type"] ?? "";
        $where = [
            ["digimr_doctor_id", $doctorId],
            ["project_id", $projectId],
            ["digimr_id", $digimrId],
            ["utm_id", $utmId],
            ["utm_campaign", $utmCampaign],
        ];
        $result = $utm_link_repository->findByMultipleFields($where);
        if ($result) {
            $result->update([
                "wave_number" => intval($result->wave_number) + 1,
            ]);
        } else {
            $utmMedium = $linkDetails["utm_medium"];
            $refId = uniqid();
            $utmLink = $linkDetails["url"] . "?ref_code=" . $refId . "&utm_source=GodMode&utm_medium=" . $utmMedium . "&utm_campaign=" . $utmCampaign . "&utm_id=" . $utmId . "&utm_content=".$utmContentType."";
            $result = $utm_link_repository->create([
                "digimr_doctor_id" => $doctorId,
                "universal_doctor_id" => $universal_doctor_id,
                "project_id" => $projectId,
                "digimr_id" => $digimrId,
                "ref_id" => $refId,
                "utm_campaign" => $utmCampaign,
                "utm_medium" => $utmMedium,
                "utm_id" => $utmId,
                "utm_link" => $utmLink,
                "wave_number" => 1,
            ]);
        }
        $app_url = config('constants.WEBSITE_URL');
        $redirectedUrl = $app_url . '/share/' . $result->ref_id;
        return $redirectedUrl;
    }
}
