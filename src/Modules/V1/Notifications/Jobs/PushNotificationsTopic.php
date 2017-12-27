<?php

namespace App\Modules\V1\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNotificationsTopic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $topic;
    protected $notification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($topic, $notification)
    {
        $this->topic        = $topic;
        $this->notification = $notification; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->push();
    }

    private function push()
    {
        $topicResponse = \FCM::sendToTopic($this->topic, null, $this->notification, null);

        \Log::useDailyFiles(storage_path().'/logs/push.log');
        \Log::info('success: ' . $topicResponse->isSuccess() . '  ,retry: ' . $topicResponse->shouldRetry() . '  ,error: ' . $topicResponse->error());
    }
}
