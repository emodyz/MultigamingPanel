<?php

namespace App\Http\Resources\Server;

use App\Http\Resources\GameResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ip' => $this->ip,
            'port' => $this->port,
            'logo_url' => $this->logo_url,
            'status' => ServerStatusResource::make($this->latestStatus()),
            'game' => GameResource::make($this->game),
            'update_hash' => $this->update_hash
        ];
    }
}
