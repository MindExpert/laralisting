<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferMade extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Offer $offer
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line("New offer ({$this->offer->amount}) was made for your listing")
            ->action(
                'See Your Listing',
                route('realtors.listings.show', ['listing' => $this->offer->listing_id])
            )
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'offer_id'   => $this->offer->id,
            'listing_id' => $this->offer->listing_id,
            'amount'     => $this->offer->amount,
            'bidder_id'  => $this->offer->bidder_id
        ];
    }
}
