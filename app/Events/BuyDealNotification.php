<?php

namespace App\Events;

use App\Events\Event;

use App\Model\BuyDeal;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BuyDealNotification extends Event implements ShouldBroadcast 
{
    use InteractsWithSockets, SerializesModels;

    public $buy_deal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BuyDeal $buy_deal)
    {
        $this->buy_deal = $buy_deal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('buy_deal'.$this->buy_deal->id);
    }
}