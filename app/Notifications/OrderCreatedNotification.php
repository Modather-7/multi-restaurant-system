<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected string $customerName;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Order $order)
    {
        $this->customerName = $this->order->customer_name ?? 'Guest';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
        // $channels = ['database']; // by default store in the database

        // if($notifiable->notification_prefrences['order_created']['sms'] ?? false){
        //     $channels[] = 'vonage';
        // }
        // if($notifiable->notification_prefrences['order_created']['mail'] ?? false){
        //     $channels[] = 'mail';
        // }
        // if($notifiable->notification_prefrences['order_created']['broadcast'] ?? false){
        //     $channels[] = 'broadcast';
        // }
        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Placed Successfully.')
            ->from('notifications@foodgrids.com', $this->order->restaurant->name)
            ->greeting("Hi, {$this->customerName}")
            ->line("A new order (#{$this->order->number}) has been created by {$this->customerName}.")
            ->action('Notification Action', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase()
    {
        return [
            'type' => 'order_created',
            'order_id' => $this->order->id,
            'body' => "A new order (#{$this->order->number}) has been created by {$this->customerName}.",
            'url'  => url('/dashboard'),
        ];
    }

    public function toBroadcast(object $notifiable)
    {
        return new BroadcastMessage([
            'type' => 'order_created',
            'order_id' => $this->order->id,
            'body' => "A new order (#{$this->order->number}) has been created by {$this->customerName}.",
            'url'  => url('/dashboard'),
        ]);
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
