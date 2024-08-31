<?php

namespace App\Jobs;

use App\Repositories\LiveEventRepository;
use App\Services\LiveEventMemberService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateCertificatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $link_id,$generated;

    public function __construct($link_id,$generated = false)
    {
        $this->link_id = $link_id;
        $this->generated = $generated;
    }

    /**
     * Execute the job
     *
     * @return void
     */
    public function handle()
    {
        try{
            $where = ['id' => $this->link_id, 'has_certificates' => true];
            $live_event_repository = new LiveEventRepository();
            $live_event_member_service = new LiveEventMemberService();
            $event = $live_event_repository->fetch($where);
            if($event){
                $live_event_repository->update(['id' => $this->link_id], ['generated_certificates' => true]);

                $live_event_member_service->fetch(['link_id' => $event->id, 'visited_during_session' => true], $event);
            }
        }catch(\Exception $e){
            Log::info(['main job' => $e]);
        }
    }
}
