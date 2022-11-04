<?php

namespace App\Repositories;

use App\Interfaces\SubscriptionTypeRepositoryInterface;
use App\Models\SubscriptionType;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;

class SubscriptionTypeRepository implements SubscriptionTypeRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredSubscriptionTypes($request)
  {
    return  SubscriptionType::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->whenSubscription($request->subscription_id)
      ->isActive($request->status)
      ->with(['school.translation','subscription.translation'])
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllSubscriptionTypes()
  {
    return  SubscriptionType::isActive(true)->withTranslation(app()->getLocale())
      ->get();
  }

  public function getSubscriptionTypeById($subscriptionTypeId)
  {
    $subscriptionType = SubscriptionType::findOrFail($subscriptionTypeId);
    return $subscriptionType;
  }

  public function getSubscriptionTypeRequestData($request)
  {
    $request_data = array_merge(['status', 'price','number_of_days', 'type', 'school_id', 'subscription_id', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createSubscriptionType($request)
  {
    $request_data = $this->getSubscriptionTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'SubscriptionTypes/', '', '');
    } //end of if

    $subscriptionType = SubscriptionType::create($request_data);

    return   $subscriptionType;
  }

  public function updateSubscriptionType($request, $subscriptionType)
  {
    $request_data = $this->getSubscriptionTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'subscriptionTypes/', $subscriptionType->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $subscriptionType->update($request_data);

    return true;
  }

  public function deleteSubscriptionType($subscriptionType)
  {
    $this->removeImage($subscriptionType->image, 'subscriptionTypes');
    $subscriptionType->delete();
    return true;
  }
}
