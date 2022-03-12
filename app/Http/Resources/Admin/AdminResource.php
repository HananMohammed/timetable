<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => [
                'id' => $this->id,
                'role' => $this->getRoleNames(),
            ],
            'name' => $this->name,
            'role' => $this->getRoleNames(),
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
