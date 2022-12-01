<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'payment_method_id', 'total_quantities', 'sub_total', 'vat', 'grand_total', 'pay', 'due'];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('id', 'like', $term)
            ->orWhereHas('customer', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id');
    }
}
