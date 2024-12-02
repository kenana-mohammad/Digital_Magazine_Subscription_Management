<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionExpiryNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ExpiredSubscripte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-subscripte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email when subscription is about to expire ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        Log::info('Subscription expiry check started.');

   
$subscriptions = Subscription::where('status', 'active')
->whereDate('end_date', '=', Carbon::now()->addDay()->toDateString()) // اشتراكات تنتهي غدًا
->get();


             
$usersToNotify = $subscriptions->map(function ($subscription) {
    return $subscription->user; 
});


Notification::send($usersToNotify, new SubscriptionExpiryNotification($subscriptions));


Log::info('Notifications sent successfully for subscriptions ending soon.');


    }

}
