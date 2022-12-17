<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'invoice_no' => $this->invoice_no,
            'payment_method' => $this->payment_method_id === 1 ? 'Cash' : 'Bank',
            'total_quantities' => $this->total_quantities,
            'sub_total' => $this->sub_total,
            'vat' => $this->vat,
            'grand_total' => $this->grand_total,
            'pay' => $this->pay === null ? '0.00' : $this->pay,
            'due' => $this->due === null ? '0.00' : $this->due,
            'transaction_id' => $this->transaction_id === null ? '' : $this->transaction_id,
            'date' => $this->created_at,
            'status' => $this->due !== null ? 'due' : 'paid',
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'details' => SaleDetailResource::collection($this->whenLoaded('sale_details'))
        ];
    }
}
