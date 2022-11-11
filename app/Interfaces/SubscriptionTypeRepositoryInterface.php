<?php

namespace App\Interfaces;

interface SubscriptionTypeRepositoryInterface
{
  public function getSubscriptionTypes();
  public function getFilteredSubscriptionTypes($request);
  public function getSubscriptionTypeById($subscriptionTypeId);
  public function createSubscriptionType($request);
  public function updateSubscriptionType($request, $subscriptionType);
  public function deleteSubscriptionType($subscriptionType);
}
