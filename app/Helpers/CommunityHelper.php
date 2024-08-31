<?php

namespace App\Helpers;

use App\Services\CommunityMapService;
use Illuminate\Support\Facades\Log;

class CommunityHelper
{
    public static function storeCommunity($communities, $map_id, $map_type)
    {
        Log::info('CommunityHelper | storeCommunity', $communities);
        self::deleteCommunity($map_id, $map_type);
        $community_map_service = new CommunityMapService();
        if (is_array($communities)) {
            foreach ($communities as $community_selected) {
                $community_map_service->store([
                    'community_id' => $community_selected,
                    'map_id' => $map_id,
                    'map_type' => $map_type
                ]);
            }
        }
    }
    //delete community based on map id and map type
    public static function deleteCommunity($map_id, $map_type)
    {
        Log::info('CommunityHelper | deleteCommunity');
        $community_map_service = new CommunityMapService();
        $community_map_service->deleteData(['map_id' => $map_id, 'map_type' => $map_type]);
    }

    // public function storeSpecialityCommunityMap($communities_selected, $speciality_id, $delete_existing = false)
    // {
    //     Log::info('CommunityHelper | storeSpecialityCommunityMap');

    //     if ($delete_existing) {
    //         SpecialityCommunityMap::where('speciality_id', $speciality_id)->delete();
    //     }

    //     if ($communities_selected) {
    //         foreach ($communities_selected as $community) {
    //             SpecialityCommunityMap::create([
    //                 'speciality_id' => $speciality_id,
    //                 'community_id' => $community
    //             ]);
    //         }
    //     }
    // }
}
