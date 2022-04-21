<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends BaseResource
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
            'email' => $this->email,
            'name' => $this->name,
            'code_login' => $this->code_login,
            'google_token' => $this->google_token,
            'status' => $this->status,
            'avatar' => str_starts_with($this->avatar, 'http') ? $this->avatar
                        : config('app.url').'/'.$this->avatar,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->whenLoaded('role', function () {
                return RoleResource::make(
                    $this->role
                );
            }),
            'position' => $this->whenLoaded('position', function () {
                return PositionResource::make(
                    $this->position
                );
            }),
            'department' => $this->whenLoaded('department', function () {
                return DepartmentResource::make(
                    $this->department
                );
            }),
            'role_id' => $this->role_id,
        ];
    }

    public function with($request)
    {
        return parent::with($request);
    }
}
