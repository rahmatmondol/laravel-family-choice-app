<?php

namespace App\Repositories;

use App\Models\Type;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredTypes($request)
  {
    return  Type::withTranslation(app()->getLocale())
      ->withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAllTypes()
  {
    return  Type::withTranslation(app()->getLocale())
      // ->withoutGlobalScope(new OrderScope)
      ->get();
  }

  public function getTypeById($typeId)
  {
    $type = Type::findOrFail($typeId);
    return $type;
  }

  public function getTypeRequestData($request)
  {
    $request_data = array_merge(['status', 'name', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createType($request)
  {
    $request_data = $this->getTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'types/', '', '');
    } //end of if

    $type = Type::create($request_data);

    return   $type;
  }

  public function updateType($request, $type)
  {
    $request_data = $this->getTypeRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'types/', $type->image);
    } //end of if

    if ($request->password) {
      $request_data['password'] = bcrypt($request->password);
    }
    $type->update($request_data);

    return true;
  }

  public function deleteType($type)
  {
    $this->removeImage($type->image, 'types');
    $type->delete();
    return true;
  }
}
