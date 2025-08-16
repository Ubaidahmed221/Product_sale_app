<?php

namespace App\Jobs;

use App\Mail\ProductPublishMail;
use App\Models\Product;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendProductPublishedMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;


    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
     $subscribers = Subscriber::all();
     foreach ($subscribers as $subscriber) {
         Mail::to($subscriber->email)
         ->queue(new ProductPublishMail($this->product));
     }
    }
}
