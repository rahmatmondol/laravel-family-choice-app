<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredAdmins($request)
  {
    return  Admin::withoutGlobalScope(new OrderScope)
      ->with(['roles'])
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAdminById($adminId)
  {
    $admin = Admin::findOrFail($adminId);
    $admin->load(['roles']);
    return $admin;
  }

  public function getAdminRequestData($request)
  {
    $request_data = $request->only(['first_name', 'last_name', 'email', 'status']);
    return $request_data;
  }

  public function createAdmin($request)
  {
    $request_data = $this->getAdminRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'admins/', '', '');
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }

    $admin = Admin::create($request_data);

    if ($request->roles) {
      $admin->attachRoles($request->roles);
    }

    return   $admin;
  }

  public function updateAdmin($request, $admin)
  {
    $request_data = $this->getAdminRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'admins/', $admin->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $admin->update($request_data);

    $roles = array_filter((array)$request->roles, function ($value) {
      return !is_null($value);
    });

    $admin->syncRoles($roles);

    return true;
  }

  public function deleteAdmin($admin)
  {
    $this->removeImage($admin->image, 'admins');
    $admin->delete();
    return true;
  }
}
