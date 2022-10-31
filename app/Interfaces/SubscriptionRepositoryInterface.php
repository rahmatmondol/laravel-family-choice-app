<?php

namespace App\Interfaces;

interface SubscriptionRepositoryInterface
{
  public function getAllSubscriptions();
  public function getFilteredSubscriptions($request);
  public function getSubscriptionById($SubscriptionId);
  public function createSubscription($request);
  public function updateSubscription($request, $Subscription);
  public function deleteSubscription($Subscription);
}
