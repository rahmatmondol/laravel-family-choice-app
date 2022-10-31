<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredSubscriptions($request)
  {
    return  Subscription::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllSubscriptions()
  {
    return  Subscription::isActive(true)->withTranslation(app()->getLocale())
      ->get();
  }

  public function getSubscriptionById($SubscriptionId)
  {
    $Subscription = Subscription::findOrFail($SubscriptionId);
    return $Subscription;
  }

  public function getSubscriptionRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createSubscription($request)
  {
    $request_data = $this->getSubscriptionRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'Subscriptions/', '', '');
    } //end of if

    $Subscription = Subscription::create($request_data);

    return   $Subscription;
  }

  public function updateSubscription($request, $Subscription)
  {
    $request_data = $this->getSubscriptionRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'Subscriptions/', $Subscription->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $Subscription->update($request_data);

    return true;
  }

  public function deleteSubscription($Subscription)
  {
    $this->removeImage($Subscription->image, 'Subscriptions');
    $Subscription->delete();
    return true;
  }
}
