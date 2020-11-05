<?php

namespace App\Events\Modpack;

use App\Models\Modpack;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModpackProcessProgress implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public float $progress;
    /**
     * @var Modpack
     */
    private Modpack $modpack;

    /**
     * ProcessModpackProgress constructor.
     * @param Modpack $modpack
     * @param float $progress
     */
    public function __construct(Modpack $modpack, float $progress)
    {
        $this->progress = $progress;
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
