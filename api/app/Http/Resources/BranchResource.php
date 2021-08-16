<?php
use Carbon\Carbon;
namespace App\Http\Resources;

use App\Http\Resources\ContactUsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'ico' => $this->ico,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at->diffForHumans(),
            // Eager + Lazy Loading
            // 'id' => $this->id,
            // 'messages' => ContactUsResource::collection($this->whenLoaded('messages')),
        ];
    }
}
