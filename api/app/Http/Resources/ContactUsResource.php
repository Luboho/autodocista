<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Branch;
use App\Http\Resources\BranchResource;
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
           'branch_id' => $this->branch_id,
           'branch' => Branch::findOrFail($this->branch_id),
           'name' => $this->name,
           'email' => $this->email,
           'phone' => $this->phone,
           'message' => $this->message,
           'read' => $this->read,
           'created_at' => $this->created_at->diffForHumans(),
           'updated_at' => $this->updated_at->diffForHumans(),
           'pagination' => $this->collection 
        ];
        // return ['data' => $this->collection];
        // // return parent::toArray($request);

        // EAger + Lazy loading
        // $branches = $this->whenLoaded('branch');
        // return [
        //     'id' => $this->id,
        //     'message' => $this->message,
        //     'branch' => new BranchResource($branches)
        // ];
    }
}
