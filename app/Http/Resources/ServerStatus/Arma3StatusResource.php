<?php

namespace App\Http\Resources\ServerStatus;

use Illuminate\Http\Resources\Json\JsonResource;

class Arma3StatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (!isset($this->resource['password'])) {
            $this->resource['password'] = 0;
        }

        if (isset($this->resource['max_players']) && isset($this->resource['num_players'])) {
            $this->resource['popularity'] = $this->resource['num_players'] *  100  / $this->resource['max_players'];
        }

        return [
            'game' => [
                'name' => $this->resource['gq_type'] ?? null,
                'description' => $this->resource['game_descr'] ?? null
            ],
            'ip' => $this->resource['gq_address'] ?? null,
            'port' => $this->resource['gq_port_client'] ?? null,
            'joinlink' => $this->resource['gq_joinlink'] ?? null,
            'online' => $this->resource['gq_online'] ?? false,
            'map' => $this->resource['map'] ?? null,
            'hostname' => $this->resource['hostname'] ?? null,
            'password' => $this->resource['password'] === 1,
            'popularity' => $this->resource['popularity'] ?? 0,
            'os' => $this->resource['os'] ?? null,
            'players' => [
                'max' => $this->resource['max_players'] ?? 0,
                'online' => $this->resource['num_players'] ?? 0,
                'list' => Arma3PlayerResource::collection($this->resource['players'] ?? [])
            ]
        ];
    }
}
