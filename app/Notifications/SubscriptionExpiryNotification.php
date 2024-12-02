<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $subscription;

    public function __construct($subscription)
    {
        //
        $this->subscription=$subscription;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        
        ->subject('تنبيه بانتهاء الاشتراك')
        ->greeting('مرحباً ' . $notifiable->name)
        ->line('نود إعلامك بأن اشتراكك سينتهي قريباً بتاريخ: ' . $this->subscription->end_date)
        ->action('تجديد الاشتراك', url('/add-subscripe/magazine/'))
        ->line('شكراً لاستخدامك خدماتنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
