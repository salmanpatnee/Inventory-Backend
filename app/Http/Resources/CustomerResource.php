<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'name' => $this->name, 
            'email' => $this->email,
            'phone' => $this->when(!is_null($this->phone), $this->phone),
            'address' => $this->when(!is_null($this->address), $this->address),
            'total_spendings' => $this->when(!is_null($this->total_spendings), $this->total_spendings),
            'last_purchase_at' => $this->when(!is_null($this->last_purchase_at), (new Carbon($this->last_purchase_at))->format('Y-m-d'))
        ];
    }
}
