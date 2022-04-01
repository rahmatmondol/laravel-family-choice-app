<?php

namespace App\Interfaces;

interface CustomerRepositoryInterface
{
  public function getFilteredCustomers($request);
  public function getCustomerById($customerId);
  public function createCustomer($request);
  public function updateCustomer($request, $customer);
  public function deleteCustomer($customer);

  #authentication
  public function loginCustomer($request);
  // public function signupCustomer($request);
  // public function updateFirebaseTokenCustomer($request);
  public function logoutCustomer($request);
  // public function profileCustomer($request);
  public function forgetCustomerPassword($request);
  public function changePasswordCustomer($request);
  public function changeCustomerPassword($request);
  public function sendCodeToCustomer($request);
  public function verifyCustomerPhone($request);
}
