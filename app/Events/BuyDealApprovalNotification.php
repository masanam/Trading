<?php

namespace App\Events;

use App\Model\BuyDealApproval;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BuyDealApprovalNotification implements ShouldBroadcast 
{
    use InteractsWithSockets, SerializesModels;

    public $buy_deal_approval;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BuyDealApproval $buy_deal_approval)
    {
        $this->buy_deal_approval = $buy_deal_approval;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('buy_deal'.$this->buy_deal_approval->buy_deal_id);
    }
}
