<?php

namespace App\Repositories;

use App\Interfaces\TransportationRepositoryInterface;
use App\Models\Transportation;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;

class TransportationRepository implements TransportationRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredTransportations($request)
  {
    return  Transportation::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      ->with(['school.translations'])
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getTransportations($request)
  {
    return  Transportation::withTranslation(app()->getLocale())
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->isActive(true)
      ->with(['school.translations'])
      ->withTranslation(app()->getLocale())
      ->paginate(request()->perPage ?? 20);
  }

  public function getTransportationById($paidService)
  {
    $paidService = Transportation::findOrFail($paidService);
    return $paidService;
  }

  public function getTransportationRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id','price', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createTransportation($request)
  {
    $request_data = $this->getTransportationRequestData($request);

    $paidService = Transportation::create($request_data);

    return   $paidService;
  }

  public function updateTransportation($request, $nurseryFee)
  {
    $request_data = $this->getTransportationRequestData($request);

    $nurseryFee->update($request_data);

    return true;
  }

  public function deleteTransportation($paidService)
  {
    $paidService->delete();
    return true;
  }
}
