<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends BaseResource
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
            // 'request_id' => $this->pivot->request_id,
            'created_by' => [
                'id' => $this->id,
                'email' => $this->email,
                'code_login' => $this->code_login,
                'name' => $this->name,
                'avatar' => str_starts_with($this->avatar, 'http') ? $this->avatar
                            : config('app.url').'/'.$this->avatar,
            ],
            'content' => json_decode($this->pivot->content),
            'created_at' => $this->pivot->created_at->format(config('common.time_format')),
        ];
    }
}
