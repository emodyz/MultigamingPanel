<?php

namespace App\Events\ModPack;

use App\Models\Modpack;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModPackProcessProgress implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public float $progress;
    /**
     * @var Modpack
     */
    private Modpack $modPack;

    /**
     * ProcessModpackProgress constructor.
     * @param Modpack $modPack
     * @param float $progress
     */
    public function __construct(Modpack $modPack, float $progress)
    {
        $this->progress = $progress;
        $this->modPack = $modPack;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("modPacks.{$this->modPack->id}");
    }
}
