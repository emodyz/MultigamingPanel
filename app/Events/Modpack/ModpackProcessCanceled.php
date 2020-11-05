<?php

namespace App\Events\Modpack;

use App\Models\Modpack;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModpackProcessCanceled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Modpack
     */
    public Modpack $modpack;

    /**
     * Create a new event instance.
     *
     * @param Modpack $modpack
     */
    public function __construct(Modpack $modpack)
    {
        $this->modpack = $modpack;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("modpacks.{$this->modpack->id}");
    }
}
