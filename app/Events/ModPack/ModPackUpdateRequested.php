<?php

namespace App\Events\ModPack;

use App\Models\Modpack;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModPackUpdateRequested implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Modpack
     */
    public Modpack $modPack;

    /**
     * Create a new event instance.
     *
     * @param Modpack $modPack
     */
    public function __construct(Modpack $modPack)
    {
        $this->modPack = $modPack;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('modPacks');
    }
}