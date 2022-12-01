<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'category_id', 'name', 'code', 'root', 'cost', 'price', 'quantity', 'purchase_date'];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
            ->orWhere('code', 'like', $term)
            ->orWhere('root', 'like', $term)
            ->orWhereHas('category', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
