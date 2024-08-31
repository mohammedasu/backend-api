<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'email'    => $this->email,
            'role'     => !empty($this->roles->first()->id) ? $this->roles->first()->id : null,
            'role_name'=> !empty($this->roles->first()->name) ? $this->roles->first()->name : null 

        ];
    }
}
