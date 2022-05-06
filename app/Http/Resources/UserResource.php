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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'apple_id' => $this->apple_id,
            'facebook_id' => $this->facebook_id,
            'google_id' => $this->google_id,
            'area_id' => $this->area_id,
            'country_id' => $this->country_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'remember_token' => $this->remember_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'delete_at' => $this->delete_at,
        ];
    }

    public function with($request)
    {
        return parent::with($request);
    }
}
