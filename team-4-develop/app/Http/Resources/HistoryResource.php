<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_by'=> $this->whenLoaded('createdBy', function () {
                return UserResource::make(
                    $this->createdBy
                );
            }),
            'request' => $this->whenLoaded('request', function () {
                return RequestResource::make(
                    $this->request
                );
            }),
            'content' => json_decode($this->content) ? json_decode($this->content) : $this->content,
            'created_at' => $this->created_at->format(config('common.time_format'))
        ];
    }
}
