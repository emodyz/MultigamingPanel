<?php

namespace App\Http\Resources\Server;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerModpackResource extends JsonResource
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
            'batch' => $this->batch,
            'manifest' => $this->manifest,
            'manifest_last_update' => $this->manifest_last_update,
        ];
    }
}
