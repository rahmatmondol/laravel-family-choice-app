<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;
use App\Traits\UploadFileTrait;
use App\Interfaces\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
  use UploadFileTrait;

  public function getAllRoles()
  {
    return Role::isActive(true)->get();
  }

  public function getFilteredRoles($request)
  {
    return  Role::whenSearch(request()->search)
      ->with(['permissions'])
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getRoleById($roleId)
  {
    $role = Role::findOrFail($roleId);
    $role->load(['permissions']);
    return $role;
  }

  public function getRoleRequestData($request)
  {
    $request_data = $request->only(['name', 'status']);
    return $request_data;
  }

  public function createRole($request)
  {
    $request_data = $this->getRoleRequestData($request);

    $this->createPermissionIfNotExist($request->permissions);

    $role = Role::create($request_data);

    $role->attachPermissions($request->permissions);

    return $role;
  }

  public function updateRole($request, $role)
  {

    $request_data = $this->getRoleRequestData($request);

    $this->createPermissionIfNotExist($request->permissions);

    $role->update($request_data);

    $role->syncPermissions($request->permissions);
    return true;
  }

  public function deleteRole($role)
  {
    $this->removeImage($role->image, 'roles');
    $role->delete();
  }

  public function createPermissionIfNotExist($newPermissions)
  {

    $permissions = Permission::pluck('name')->toArray();

    $permissionsNotExists = array_diff($newPermissions, $permissions);

    foreach ($permissionsNotExists as $new) {

      Permission::create(['name' => $new]);
    }

    return true;
  }
}
