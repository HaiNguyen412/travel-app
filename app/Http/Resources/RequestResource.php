<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends BaseResource
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
            'name' => $this->name,
            'content' => $this->content,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'created_at' => $this->created_at->format(config('common.time_format')),
            'priority' => $this->whenLoaded('priority', function () {
                return RoleResource::make(
                    $this->priority
                );
            }),
            'category' => $this->whenLoaded('category', function () {
                return CategoryResource::make(
                    $this->category
                );
            }),
            'created_by' => $this->whenLoaded('createdBy', function () {
                return UserResource::make(
                    $this->createdBy
                );
            }),
            'updated_by'=> $this->whenLoaded('updatedBy', function () {
                return UserResource::make(
                    $this->updatedBy
                );
            }),
            'approve'=> $this->whenLoaded('approveBy', function () {
                return UserResource::make(
                    $this->approveBy->load('role')
                );
            }),
            'assignee'=> $this->whenLoaded('assigneeId', function () {
                return UserResource::make(
                    $this->assigneeId
                );
            }),
            'comments'=> $this->whenLoaded('users', function () {
                return CommentResource::collection($this->users);
            }),
        ];
    }

    public function with($request)
    {
        return parent::with($request);
    }
}
