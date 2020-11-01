<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'status' => ServerStatusResource::make($this->status()->latest()->first()),
            'game' => GameResource::make($this->game),
        ];
    }
}
