<?php

namespace App\Events;

use App\Models\Product;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductAfterUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;

    public $fields;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( Product $product, $fields )
    {
        $this->product = $product;
        $this->fields = $fields;
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
