<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CatalogChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;
    public $old_data;
    public $new_data;
    /**
     * Create a new event instance.
     */
    public function __construct($action, $newData, $oldData)
    {
        //
        $this->action = $action;
        $this->old_data = $oldData;
        $this->new_data = $newData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
