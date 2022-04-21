<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JwtResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $expiresAt = Carbon::parse($this['expires_at'])->format('Y-m-d H:i:s.u');
        $user = Auth::user();
        return [
            'access_token' => $this['access_token'],
            'expires_at' => $expiresAt,
            'user'=> UserResource::make($user->load(['role','position','department'])),

            
        ];
    }
}
