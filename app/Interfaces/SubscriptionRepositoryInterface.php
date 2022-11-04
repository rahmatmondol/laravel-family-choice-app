<?php

namespace App\Interfaces;

interface SubscriptionRepositoryInterface
{
  public function getAllSubscriptions();
  public function getFilteredSubscriptions($request);
  public function getSubscriptionById($subscriptionId);
  public function createSubscription($request);
  public function updateSubscription($request, $subscription);
  public function deleteSubscription($subscription);
}
