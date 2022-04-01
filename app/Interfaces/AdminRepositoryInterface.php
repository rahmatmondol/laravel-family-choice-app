<?php

namespace App\Interfaces;

interface AdminRepositoryInterface
{
  public function getFilteredAdmins($request);
  public function getAdminById($adminId);
  public function createAdmin($request);
  public function updateAdmin($request, $admin);
  public function deleteAdmin($admin);
}
