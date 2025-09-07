<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;


    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {
        //
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          sendPushNotification($this->order->user_id,$this->order->id,"#{$this->order->id} status updated","Your order status is ".ucfirst($this->order->status));

    }
}
