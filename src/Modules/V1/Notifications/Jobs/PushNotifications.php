<?php

namespace App\Modules\V1\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $option;
    protected $notification;
    protected $data;
    protected $tokens;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($option, $notification, $data, $tokens)
    {
        $this->option       = $option;
        $this->notification = $notification; 
        $this->data         = $data; 
        $this->tokens       = $tokens;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->push($this->tokens);
    }

    private function push($tokens)
    {
        $downstreamResponse = \FCM::sendTo($tokens, $this->option, $this->notification, $this->data);

        \Core::pushNotificationDevices()->model->whereIn('device_token', $downstreamResponse->tokensToDelete())->forceDelete();
        \Core::pushNotificationDevices()->model->whereIn('device_token', $downstreamResponse->tokensWithError())->forceDelete();

        foreach ($downstreamResponse->tokensToModify() as $old => $new) 
        {
            if ($oldDevice = \Core::pushNotificationDevices()->model->where('device_token', $old)->first()) 
            {
                \Core::pushNotificationDevices()->save([
                    'id'           => $oldDevice->id,
                    'device_token' => $new
                ]);
            }
        } 

        $retry = $downstreamResponse->tokensToRetry();
        if (count($retry)) 
        {
            $this->push($retry);
        }
    }
}
