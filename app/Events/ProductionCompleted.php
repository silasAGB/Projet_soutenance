<?php

namespace App\Events;

use App\Models\Production;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductionCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $production;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Production  $production
     * @return void
     */
    public function __construct(Production $production)
    {
        $this->production = $production;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('production');
    }
}
