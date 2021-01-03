<?php

namespace App\Http\Resources\ModPack;

use App\Http\Resources\Server\ServerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModPackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'batch' => $this->batch,
            'game' => $this->game,
            'servers' => ServerResource::collection($this->servers),
            'manifest' => $this->manifest,
            'manifest_last_update' => $this->manifest_last_update,
        ];
    }
}
