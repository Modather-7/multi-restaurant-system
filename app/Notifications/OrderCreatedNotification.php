<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
        $channels = ['database']; // by default store in the database

        if($notifiable->notification_prefrences['order_created']['sms'] ?? false){
            $channels[] = 'vonage';
        }
        if($notifiable->notification_prefrences['order_created']['mail'] ?? false){
            $channels[] = 'mail';
        }
        if($notifiable->notification_prefrences['order_created']['broadcast'] ?? false){
            $channels[] = 'broadcast';
        }
        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $customerName = $this->order->customer_name ?? 'Guest';
        return (new MailMessage)
            ->subject('Order Placed Successfully.')
            ->from('notifications@foodgrids.com', $this->order->restaurant->name)
            ->greeting("Hi, {$customerName}")
            ->line("A new order (#{$this->order->number}) has been created by {$customerName}.")
            ->action('Notification Action', url('/dashboard'))
            ->line('Thank you for using our application!');
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
