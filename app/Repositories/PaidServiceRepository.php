<?php

namespace App\Repositories;

use App\Interfaces\PaidServiceRepositoryInterface;
use App\Models\PaidService;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use Illuminate\Database\Eloquent\Model;

class PaidServiceRepository implements PaidServiceRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredPaidServices($request)
  {
    return  PaidService::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      ->with(['school.translations'])
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getPaidServices($request)
  {
    return  PaidService::withTranslation(app()->getLocale())
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->WhenSubscription($request->subscription_id)
      ->isActive(true)
      ->with(['school.translations'])
      ->withTranslation(app()->getLocale())
      ->paginate(request()->perPage ?? 20);
  }

  public function getPaidServiceById($paidService)
  {
    $paidService = PaidService::findOrFail($paidService);
    return $paidService;
  }

  public function getPaidServiceRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id','price', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createPaidService($request)
  {
    $request_data = $this->getPaidServiceRequestData($request);

    $paidService = PaidService::create($request_data);

    return   $paidService;
  }

  public function updatePaidService($request, $nurseryFee)
  {
    $request_data = $this->getPaidServiceRequestData($request);

    $nurseryFee->update($request_data);

    return true;
  }

  public function deletePaidService($paidService)
  {
    $paidService->delete();
    return true;
  }
}
