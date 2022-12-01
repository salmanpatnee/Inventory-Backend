<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'amount', 'paid_date', 'month', 'year'];

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where('amount', 'like', $term)
            ->orWhereHas('employee', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
