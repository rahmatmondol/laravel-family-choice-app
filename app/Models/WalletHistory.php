<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletHistory extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function scopeWhenType($query, $type = null)
  {
    return $query->when($type, function ($q) use ($type) {
      return $q->where('type', $type);
    });
  } // end of scopeWhenSearch

  public function scopeWhenCustomer($query, $customer_id = null)
  {
    return $query->when($customer_id, function ($q) use ($customer_id) {
      return $q->where('customer_id', $customer_id);
    });
  } // end of scopeWhenSearch

  public function customer(): BelongsTo
  {
      return $this->belongsTo(Customer::class, 'customer_id', 'id');
  }
}
