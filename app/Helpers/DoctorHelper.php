<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Constants\Constants;
use App\Models\Doctor;
use App\Models\ProductDetails;
use App\Models\TelecallerProducts;
use App\Models\Universal3;
use Illuminate\Queue\ManuallyFailedException;

class DoctorHelper
{

    public static function doctorAssign($request)
    {
        try{
            // Log::info(['DoctorAssign' => $request]);
            // // dd($request['member_ref_no']);
            // // $universalDoctor = $this->universal;
            $universal_member_ref_no = $request['member_ref_no'];
            $universalDoctor = Universal3::where('member_ref_no',$universal_member_ref_no)->first();
            $doctor = Doctor::where("universal_member_ref_no", $universal_member_ref_no)->first();
            if(!$doctor)
            {
                $doctor = Doctor::where("mobile_number", $universalDoctor->mobile_number)->where("country_code", $universalDoctor->country_code)->first();
                if(!$doctor)
                {
                    $data = [
                        "first_name" => $universalDoctor->first_name,
                        "last_name" => $universalDoctor->last_name,
                        "email" => $universalDoctor->email,
                        "mobile_number" => $universalDoctor->mobile_number,
                        "alternate_number" => $universalDoctor->alternate_number,
                        "whatsapp_number" => $universalDoctor->whatsapp_number,
                        "state" => $universalDoctor->state,
                        "city" => $universalDoctor->city,
                        "speciality" => $universalDoctor->speciality ?? null,
                        "universal_member_ref_no" => $universalDoctor->member_ref_no
                    ];
                    $doctor = Doctor::create($data);
                    if (!$doctor) {
                        throw new ManuallyFailedException("something went wrong while inserting doctor");
                        Log::info("something went wrong while inserting doctor");
                        return;
                    }
                }
                else{
                    $doctor->universal_member_ref_no = $universalDoctor->member_ref_no;
                    $doctor->save();
                }
            }
            $project = config('digiMR.DOCTOR_VERIFICATION_PROJECT_NAME');
            $project = ProductDetails::where('title', $project)->first();
            if(!$project)
            {
                throw new ManuallyFailedException("doctor verification project not found");
                Log::info("doctor verification project not found");
                return;
            }
            $digiMrIds = $project->telecallers()->pluck("telecaller_id")->toArray();
            if(!count($digiMrIds))
            {
                throw new ManuallyFailedException("No any digimr assign in this project");
                Log::info("No any digimr assign in this project");
                return;
            }
            $key = array_rand($digiMrIds);
            $digiMrId = $digiMrIds[$key];
            $where = [
                ['project_id', $project->id],
                ['doctor_id', $doctor->id]
            ];
            $telecallerProducts = TelecallerProducts::where($where)->first();
            if ($telecallerProducts) {
                throw new ManuallyFailedException("This doctor ".$doctor->id." already assign in doctor verification project with digimr ".$telecallerProducts->telecaller_id);
                Log::info("This doctor ".$doctor->id." already assign in doctor verification project with digimr ".$telecallerProducts->telecaller_id);
                return;
            }
            $telecallerProducts = TelecallerProducts::create([
                'reference_number' => 'TPRD' . UtilityHelper::generateString(),
                'project_id' => $project->id,
                'telecaller_id' => $digiMrId,
                'doctor_id' => $doctor->id
            ]);
            if (!$telecallerProducts) {
                throw new ManuallyFailedException("something went wrong while inserting in telecllaer product");
                Log::info("something went wrong while inserting in telecllaer product");
                return;
            }
            return [
                'status' => true,
                'message' => 'updated successfully'
            ];
        }catch(ManuallyFailedException $manually_failed_exception){
            return [
                'status' => false,
                'message' => $manually_failed_exception->getMessage()
            ];
        }
    }
}
