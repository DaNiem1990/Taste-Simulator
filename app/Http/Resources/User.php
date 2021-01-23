<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed email
 * @property mixed isadmin
 * @property mixed is_active
 * @property mixed only_friends
 * @property mixed friends
 */
class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'isadmin' => $this->isadmin,
            'is_active' => $this->is_active,
            'only_frieds' => $this->only_friends,
            'friends' => $this->friends,
        ];
    }
}
