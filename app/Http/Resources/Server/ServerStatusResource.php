<?php

namespace App\Http\Resources\Server;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerStatusResource extends JsonResource
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
            'online' => $this->online,
            'players_max' => $this->players_max,
            'players_online' => $this->players_online,
            'created_at' => $this->created_at
        ];
    }
}
