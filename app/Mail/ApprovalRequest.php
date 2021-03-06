<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Model\Order;

class ApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $approval_token, $index_price, $index_name)
    {
        $this->order = $order;
        $this->approval_token = $approval_token;
        $this->index_price = $index_price;
        $this->index_name = $index_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@volantech.io')
            ->view('mail.order.approval')
            ->with([
                'order' => $this->order,
                'approval_token' => $this->approval_token,
                'index_price' => $this->index_price,
                'index_name' => $this->index_name
            ]);
            //->text('mail.order.detail');
    }
}
