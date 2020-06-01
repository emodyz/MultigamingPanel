<?php

namespace App\Http\Resources\ServerStatus;

use Illuminate\Http\Resources\Json\JsonResource;

class Arma3PlayerResource extends JsonResource
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
            'name' => $this->resource['name'] ?? 'Undefined',
            'time' => $this->resource['time'] ?? 0,
        ];
    }
}
