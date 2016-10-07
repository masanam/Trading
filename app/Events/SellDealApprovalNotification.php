<?php

namespace App\Events;

use App\Model\SellDealApproval;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SellDealApprovalNotification implements ShouldBroadcast 
{
    use InteractsWithSockets, SerializesModels;

    public $sell_deal_approval;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SellDealApproval $sell_deal_approval)
    {
        $this->sell_deal_approval = $sell_deal_approval;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('sell_deal'.$this->sell_deal_approval->sell_deal_id);
    }
}
