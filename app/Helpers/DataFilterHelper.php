<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Exception;
use App\Repositories\DataFilterRepository;
use App\Repositories\Universal3Repository;

class DataFilterHelper
{
    public static function bifurcateFilters($params)
    {
        Log::info('DataFilterHelper | bifurcateFilters', $params);
        $universal_filters = [
            'zone_selected' => $params['zone_selected'],
            'zone_negative_selected' => $params['zone_negative_selected'],
            'tier_selected' => $params['tier_selected'],
            'tier_negative_selected' => $params['tier_negative_selected'],
            'state_selected' => $params['state_selected'],
            'state_negative_selected' => $params['state_negative_selected'],
            
            'city_selected' => $params['city_selected'],
            'main_city_selected' => $params['main_city_selected'],
            'metro_city_selected' => $params['metro_city_selected'],

            'city_negative_selected' => $params['city_negative_selected'],
            'main_city_negative_selected' => $params['main_city_negative_selected'],
            'metro_city_negative_selected' => $params['metro_city_negative_selected'],
            
            'speciality_selected' => $params['speciality_selected'],
            'speciality_negative_selected' => $params['speciality_negative_selected'],
            'digiMR_status' => $params['digiMR_status'],
            'digiMR_negative_status' => $params['digiMR_negative_status'],
            'whatsapp_active_status' => $params['whatsapp_active_status'],
            'whatsapp_active_negative_status' => $params['whatsapp_active_negative_status'],
            'sms_active_status' => $params['sms_active_status'],
            'sms_active_negative_status' => $params['sms_active_negative_status'],
            'member_type' => $params['member_type'],
            'member_negative_type' => $params['member_negative_type'],
            'last_active_since' => $params['last_active_since'],
            'countries_selected' => $params['countries_selected'],
            'countries_negative_selected' => $params['countries_negative_selected'],
        ];

        $live_event_filters = [
            'live_event_registered' => $params['live_event_registered'],
            'live_event_registered_check' => $params['live_event_registered_check'],
            'live_event_visited' => $params['live_event_visited'],
            'live_event_visited_check' => $params['live_event_visited_check'],
            'live_event_partner' => $params['live_event_partner'],
            'live_event_partner_division_id' => $params['live_event_partner_division_id'],
        ];

        $member_filters = [
            'forum_subscription' => $params['forum_subscription'],
            'forum_subscription_check' => $params['forum_subscription_check'],
            'video_watched' => $params['video_watched'],
            'video_watched_check' => $params['video_watched_check'],
            'answered_case' => $params['answered_case'],
            'answered_case_check' => $params['answered_case_check'],
            'member_is_prime' => $params['member_is_prime'],
        ];

        return ['universal_filters' => $universal_filters, 'live_event_filters' => $live_event_filters, 'member_filters' => $member_filters];
    }
    public static function getFilterData($filter_id, $action = 'check')
    {
        Log::info(['Request to get data filter' => $action]);
        $data_filter_repository = new DataFilterRepository();
        $universal_repository = new Universal3Repository();

        try {
            $filter_object = $data_filter_repository->findByMultipleFields(['id' => $filter_id]);
            $universal_filters = $filter_object['universal_filters'];
            $member_filters = $filter_object['member_filters'];
            $live_event_filters = $filter_object['live_event_filters'];

            $filter_response =  $universal_repository->filterDataFromRepository($universal_filters, $member_filters, $live_event_filters, $action);
            if ($action == 'check') {
                $filter_object->data_count = $filter_response;
                $filter_object->save();
                return $filter_object;
            }

            return $filter_response;
        } catch (Exception $exception) {
            Log::info(['Error while calculating data filter']);
            Log::info($exception);
            throw new Exception($exception);
        }
    }
}
