<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Laravel\Nova\Notifications\NovaChannel;
use Laravel\Nova\Notifications\NovaNotification;

class OrderNotification extends Notification
{
    use Queueable;

    protected $orderId;

    /**
     * @param $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @param object $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return [NovaChannel::class, "mail"];
    }

    /**
     * @param object $notifiable
     * @return NovaNotification
     */
    public function toNova(object $notifiable): NovaNotification
    {
        return (new NovaNotification)
            ->message("Yeni bir sifariş mövcuddur! (#{$this->orderId})")
            ->action('Sifarişi Gör', "/resources/orders/{$this->orderId}")
            ->icon('shopping-cart');
    }

    /**
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🛒 Yeni Sifariş (#{$this->orderId}) Alındı!")
            ->view('emails.order_details', [
                'order' => Order::query()->with('user')->find($this->orderId)
            ]);
    }
}
