<?php

namespace App\Jobs;

use App\Models\MemberCertificate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\Certificate;

class GenerateCertificatesSubJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $l_members,$event;

    public function __construct($l_members,$event)
    {
        $this->l_members = $l_members;
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $l_members = $this->l_members;
            $event = $this->event;
            $l_members->each(function($l_member,$index) use ($event){
                $member = Member::where('mobile_number',$l_member->mobile_number)
                                ->where('country_code',$l_member->country_code)
                                ->latest()->first();
                $template = Certificate::where('id',$event->certificate_id)->first();

                if ($template) {
                    $html = $template->template;
                    $html = str_replace('id="MEDI_F1"', 'id="NAME"', $html);
                    $html = str_replace('#MEDI_F1', '#NAME', $html);
                    $html = str_replace('MEDI_F1', strtoupper(($member ? $member->fname : (string)$l_member->fname)) . ' ' . strtoupper(($member ? $member->lname : (string)$l_member->lname)), $html);
                    // $html = str_replace('F2', strtoupper((string)$member->lname), $html);
                    if ($template->image_fillers != null) {
                        foreach ($template->image_fillers as $index2 => $filler) {
                            $encode = 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/members/certificates/template/images/' . $filler['file'])));
                            $html = str_replace('id="'.$filler['filler'].'"','id="IMG'.$index2.'"',$html);
                            $html = str_replace('#'.$filler['filler'].'','#IMG'.$index2.'',$html);
                            $html = str_replace(''.$filler['filler'].'.png',$encode,$html);
                        }
                    }
                    $image = Str::random(2) . time() . ($member ? $member->id : $index);

                    $added = true;
                    $node_path = env('NODE_PATH') != null ? env('NODE_PATH') : \Config('app.NODE_PATH');
                    $npm_path = env('NPM_PATH') != null ? env('NPM_PATH') : \Config('app.NPM_PATH');

                    Browsershot::html($html)
                    ->setNodeBinary($node_path)
                    ->setNpmBinary($npm_path)
                    ->dismissDialogs()
                    ->noSandbox()
                    ->waitUntilNetworkIdle()
                    ->ignoreHttpsErrors()
                    ->fullPage()
                    ->save(storage_path('app/public/members/certificates/'.$image.'.pdf'));

                    Browsershot::html($html)
                    ->setNodeBinary($node_path)
                    ->setNpmBinary($npm_path)
                    ->dismissDialogs()
                    ->noSandbox()
                    ->waitUntilNetworkIdle()
                    ->ignoreHttpsErrors()
                    ->fullPage()
                    ->save(storage_path('app/public/members/certificates/'.$image.'.png'));

                    Storage::disk('s3')->put('certificates/'.$image.'.pdf',\file_get_contents(storage_path('app/public/members/certificates/' . $image .'.pdf')));
                    Storage::disk('s3')->put('certificates/'.$image.'.png',\file_get_contents(storage_path('app/public/members/certificates/' . $image . '.png')));

                    Storage::disk('public')->delete('members/certificates/' . $image . '.pdf');
                    Storage::disk('public')->delete('members/certificates/' . $image . '.png');

                    if ($added) {
                        $member_certificate = null;
                        if($member){
                            $member_certificate = MemberCertificate::when($member,function($q) use ($member){
                                                    return $q->where(function($q)use ($member){
                                                        return $q->where('member_id',$member->id)
                                                                ->orWhere(function($q) use ($member){
                                                                    return $q->where('country_code',$member->country_code)
                                                                            ->where('mobile_number',$member->mobile_number);
                                                                });
                                                    });
                                                })
                                                ->where('live_event_id', $event->id)->first();
                        }else{
                            $member_certificate = MemberCertificate::where(function($q)use ($l_member,$event){
                                                    return $q->where('mobile_number', $l_member->mobile_number)
                                                                ->where('country_code', $l_member->country_code)
                                                                ->where('live_event_id', $event->id);
                                                })
                                                ->orWhere('live_event_member_id',$l_member->id)
                                                ->first();
                        }

                        if ($member_certificate) {
                            if (Storage::disk('s3')->exists('certificates/'.$member_certificate->file_name.'.png')) {
                                Storage::disk('s3')->delete('certificates/'.$member_certificate->file_name.'.png');
                            }
                            if (Storage::disk('s3')->exists('certificates/'.$member_certificate->file_name.'.pdf')) {
                                Storage::disk('s3')->delete('certificates/'.$member_certificate->file_name.'.pdf');
                            }
                            if (Storage::disk('s3')->exists('certificates/'.$member_certificate->file_name.'.jpeg')) {
                                Storage::disk('s3')->delete('certificates/'.$member_certificate->file_name.'.jpeg');
                            }
                        }

                        if ($member_certificate) {
                            if($member){
                                $member_certificate->update([
                                    'member_id' => $member->id,
                                    'certificate_id' => $event->certificate_id,
                                    'live_event_id' => $event->id,
                                    'file_name' => $image,
                                    'image_name' => $image,
                                    'live_event_member_id' => $l_member->id,
                                ]);
                            }else{
                                $member_certificate->update([
                                    'mobile_number' => $l_member->mobile_number,
                                    'country_code' => $l_member->country_code,
                                    'certificate_id' => $event->certificate_id,
                                    'live_event_id' => $event->id,
                                    'file_name' => $image,
                                    'image_name' => $image,
                                    'live_event_member_id' => $l_member->id,
                                ]);
                            }
                        }else{
                            MemberCertificate::create([
                                'mobile_number' => $l_member->mobile_number,
                                'country_code' => $l_member->country_code,
                                'certificate_id' => $event->certificate_id,
                                'live_event_id' => $event->id,
                                'file_name' => $image,
                                'image_name' => $image,
                                'live_event_member_id' => $l_member->id,
                            ]);
                        }
                    }
                }
            });
        }catch(\Exception $e){
            Log::info($e);
        }
    }
}
