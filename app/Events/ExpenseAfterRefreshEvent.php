<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExpenseAfterRefreshEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;

    public $date;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $event, $date )
    {
        $this->event = $event;
        $this->date = $date;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('ns.private-channel');
    }
}
