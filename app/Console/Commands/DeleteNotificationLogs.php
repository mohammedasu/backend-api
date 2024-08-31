<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MemberNotificationService;
use Carbon\Carbon;

class DeleteNotificationLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:notification-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will delete all notification logs of last given days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notificationService = new MemberNotificationService();
        $date = Carbon::now()->subDays(config('constants.delete_notification_logs_days'));
        $notificationService->deleteNotificationLogs($date);
        echo "Notification Logs deleted successfully";
        return 0;
    }
}
