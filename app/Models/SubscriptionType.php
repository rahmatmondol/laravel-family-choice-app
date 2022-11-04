<?php

namespace App\Models;

use App\Scopes\OrderScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
  use HasFactory;
  use \Astrotomic\Translatable\Translatable;
  protected $guarded = [];

  public $translatedAttributes = ['title', 'appointment'];

  public $translationForeignKey = 'sub_type_id';

  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope(new OrderScope);
  }

  public function scopeIsActive($query, $status = null)
  {
    if ($status != null)
      return $query->where('status', (bool)$status);
  }

  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {

      return $q->whereTranslationLike('title', '%' . $search . '%');
    });
  } // end of scopeWhenSearch

  public function scopeWhenSubscription($query, $subscription_id)
  {
    return $query->when($subscription_id, function ($q) use ($subscription_id) {

      return $q->whereHas('subscription', function ($qu) use ($subscription_id) {

        return $qu->whereIn('subscription_id', (array)$subscription_id);
      });
    });
  }

  public function school()
  {
    return $this->belongsTo(School::class);
  }

  public function subscription()
  {
    return $this->belongsTo(Subscription::class);
  }
}
