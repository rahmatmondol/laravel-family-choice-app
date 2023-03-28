<?php

namespace App\Repositories;

use App\Models\Service;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredServices($request)
  {
    return  Service::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllServices()
  {
    return  Service::withTranslation(app()->getLocale())
      // ->withoutGlobalScope(new OrderScope)
      ->get();
  }

  public function getServiceById($typeId)
  {
    $service = Service::findOrFail($typeId);
    return $service;
  }

  public function getServiceRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createService($request)
  {
    $request_data = $this->getServiceRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'services/', '', '');
    } //end of if

    $service = Service::create($request_data);

    return   $service;
  }

  public function updateService($request, $service)
  {
    $request_data = $this->getServiceRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'ervices/', $service->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $service->update($request_data);

    return true;
  }

  public function deleteService($service)
  {
    $this->removeImage($service->image, 'ervices');
    $service->delete();
    return true;
  }
}
