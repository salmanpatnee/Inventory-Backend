<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product_id' => $this->product_id, 
            'product' => new ProductResource($this->product), 
            'quantity' => $this->quantity, 
            'unit_price' => $this->unit_price, 
            'sub_total' => $this->sub_total, 
        ];
    }
}
