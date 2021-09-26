<?php

use Carbon\Carbon;
namespace App\Http\Resources;

use App\Models\Branch;
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
        $role;

        $arrayData = [
            'id' => $this->id,
            'branch' => Branch::findOrFail($this->branch_id),
            'branch_id' => $this->branch_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at->format('d.m. Y'),
        ];

        if($this->is_admin == '1') {
            $arrayData['role'] = 'Admin';
        } elseif($this->is_admin == '0') {
            $arrayData['role'] = 'Užívateľ';
        }

        return $arrayData;
    }
}
