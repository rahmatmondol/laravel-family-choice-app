<?php

namespace App\Services\School;

use App\Models\NurserySubscription;
use Illuminate\Support\Facades\DB;

class NurserySubscriptionService
{

  public static function getNurserySubscriptions($school)
  {
    return $school->subscriptions;
  }

  public static function getNurserySubscription($school, $subscription)
  {
    return NurserySubscription::where([['school_id', $school->id], ['subscription_id', $subscription->id]])->firstOrFail();
  }

  public static function storeNurserySubscription($request,$school_id)
  {
    DB::table('nursery_subscription')->updateOrInsert(['subscription_id' => $request->subscription_id, 'school_id' => $school_id], [
      'status' => $request->status
    ]);
  }

  public static function updateNurserySubscription($request, $school, $subscription)
  {
    DB::table('nursery_subscription')->updateOrInsert(['subscription_id' => $subscription->id, 'school_id' => $school->id], [
      'status' => $request->status
    ]);
  }

  public static function deleteNurserySubscription($school, $subscription)
  {
    NurserySubscription::where([['school_id', $school->id], ['subscription_id', $subscription->id]])->delete();
  }
}
