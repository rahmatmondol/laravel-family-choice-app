<?php

namespace App\Interfaces;

interface UserManualRepositoryInterface
{
  public function getFilteredUserManuals($request);
  public function getUserManuals($request);
  public function getUserManualById($user_manualId);
  public function createUserManual($request);
  public function updateUserManual($request, $user_manual);
  public function deleteUserManual($user_manual);
}
