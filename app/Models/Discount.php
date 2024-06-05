<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'title',
        'discount_type',
        'discount_amount',
        'percentage_discount',
        'minimum_amount',
        'starting_date',
        'ending_date',
        'status',
    ];
    protected $dates = [
        'starting_date',
        'ending_date',
        // Add other date fields here if needed
    ];

    public function schools()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
    public function scopeWhenStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
