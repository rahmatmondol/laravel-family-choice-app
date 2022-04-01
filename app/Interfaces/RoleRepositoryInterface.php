<?php

namespace App\Interfaces;

interface RoleRepositoryInterface
{
  public function getAllRoles();
  public function getFilteredRoles($request);
  public function getRoleById($roleId);
  public function createRole($request);
  public function updateRole($request, $role);
  public function deleteRole($role);
}
