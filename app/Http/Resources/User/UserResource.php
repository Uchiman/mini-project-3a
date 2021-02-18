<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (empty($this->email_verified_at)) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'vertify' => "true",
                'role' => $this->getRoleNames()
        ];
        }
        return [
                'name' => $this->name,
                'email' => $this->email,
                'vertify' => "false",
                'role' => $this->getRoleNames()
        ];
    }
}
