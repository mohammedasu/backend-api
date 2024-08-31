<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\SubSpecialityMapService;
use App\Services\ExpertMapService;
use App\Services\SpecialityCommunityMapService;
use Illuminate\Support\Str;

class CommonHelper
{
    public static function downloadFile($fileName)
    {
        return response()->download(storage_path($fileName));
    }
    public static function getURLLink($name, $add_doctor_prefix): string
    {
        $name = strtolower($name);

        if ($add_doctor_prefix) {
            $name = ltrim($name, 'dr.');
            $name = ltrim($name, 'dr');
        }

        $name = preg_replace('/\s+/', '-', $name);

        $name = ltrim($name, '-');

        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        $unique_link=Str::uuid();
        if ($add_doctor_prefix) {
            return 'dr' . '-' . $name.$unique_link;
        } else {
            return $name.$unique_link;
        }
    }
    // delete and store Sub Specialities based on map id and map type
    public static function storeSubSpecialities($sub_speciality_selected, $map_id, $map_type, bool $delete_existing = false)
    {
        Log::info(['Sub specialities selected' => $sub_speciality_selected]);
        $sub_speciality_map_service = new SubSpecialityMapService();
        if ($delete_existing) {
            Log::info(['Deleting Sub specialities' => $sub_speciality_selected]);
            $params['map_id'] = $map_id;
            $params['map_type'] = $map_type;
            $sub_speciality_map_service->destroyData($params);
        }

        if ($sub_speciality_selected) {
            foreach ($sub_speciality_selected as $sub_speciality) {
                if(!empty($sub_speciality)) {
                    $sub_speciality_map_service->store([
                        'sub_speciality_id' => $sub_speciality,
                        'map_id' => $map_id,
                        'map_type' => $map_type
                    ]);
                }
            }
        }
    }

    public static function storeExpertMap($experts, $map_id, $map_type)
    {
        Log::info(['Expert selected' => $experts]);
        $expert_map_service = new ExpertMapService();
        $expert_map_service->delete(['map_id' => $map_id, 'map_type' => $map_type]);
        if ($experts) {
            foreach ($experts as $expert) {
                $expert_map_service->store(['map_id' => $map_id, 'map_type' => $map_type, 'expert_id' => $expert]);
            }
        }
    }
    public static function storeSpecialityCommunityMap($communities_selected, $speciality_id, $delete_existing = false)
    {
        Log::info(['Community selected' => $communities_selected]);

        $speciality_community_map_service = new SpecialityCommunityMapService();
        if ($delete_existing) {
            $speciality_community_map_service->delete(['speciality_id' => $speciality_id]);
        }

        if ($communities_selected) {
            foreach ($communities_selected as $community) {
                $speciality_community_map_service->create([
                    'speciality_id' => $speciality_id,
                    'community_id' => $community
                ]);
            }
        }
    }

    public static function filterColumnForResponse($column_array, $response_array)
    {
        $return_array = array();

        foreach ($column_array as  $value) {
            $return_array[$value] = isset($response_array[$value]) ? $response_array[$value] : null;
        }

        return $return_array;
    }

    public static function storeImage($image_object, $folderName, $key_name = null, $add_timestamp = true, $disk = 'public')
    {

        Log::info(['CommonHelper' => $folderName]);

        $img = $image_object;

        $file_name = str_replace(" ", "_", $img->getClientOriginalName());
        if ($add_timestamp) {
            $file_name = Carbon::now()->timestamp . $file_name;
        }

        Log::info(['Adding image ' => $file_name, 'folder name ' => $folderName]);

        if ($disk == 'public') {
            Log::info($folderName);
            $folderName = 'images/' . $folderName;
            $file_upload_success = Storage::disk($disk)->put($folderName . '/' . $file_name, file_get_contents($img), 'public');
        } else {
            $file_upload_success = Storage::disk($disk)->put($folderName . '/' . $file_name, file_get_contents($img));
        }


        Log::info(['Uploading folder status ' => $file_upload_success]);

        return ($file_upload_success) ? $file_name : null;
    }
}
