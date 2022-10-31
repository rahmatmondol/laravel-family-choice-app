<?php

namespace App\Services\School;

use App\Models\SchoolSubscription;
use Illuminate\Support\Facades\DB;

class SchoolSubscriptionService
{

  public static function getSchoolSubscriptions($school)
  {
    // dd($school->subscriptions);
    return $school->subscriptions;
  }

  public static function getSchoolSubscription($school, $subscription)
  {
    return SchoolSubscription::where([['school_id', $school->id], ['subscription_id', $subscription->id]])->firstOrFail();
  }

  public static function storeSchoolSubscription($request,$school_id)
  {
    DB::table('school_subscription')->updateOrInsert(['subscription_id' => $request->subscription_id, 'school_id' => $school_id], [
      'status' => $request->status
    ]);
  }

  public static function updateSchoolSubscription($request, $school, $subscription)
  {
    DB::table('school_subscription')->updateOrInsert(['subscription_id' => $subscription->id, 'school_id' => $school->id], [
      'status' => $request->status
    ]);
  }

  public static function deleteSchoolSubscription($school, $subscription)
  {
    SchoolSubscription::where([['school_id', $school->id], ['subscription_id', $subscription->id]])->delete();
  }
}
