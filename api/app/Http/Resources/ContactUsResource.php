<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
           'id' => $this->id,
           'name' => $this->name,
           'email' => $this->email,
           'phone' => $this->phone,
           'message' => $this->message,
           'read' => $this->read,
           'created_at' => $this->created_at->diffForHumans(),
           'updated_at' => $this->updated_at->diffForHumans()
       ];
    }
}
