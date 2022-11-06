<?php

namespace App\Repositories;

use App\Models\NurseryFees;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\NurseryFeesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class NurseryFeesRepository implements NurseryFeesRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredNurseryFees($request)
  {
    return  NurseryFees::withoutGlobalScope(new OrderScope)
      ->withTranslation(app()->getLocale())
      ->with(['school.translations'])
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getNurseryFees($request)
  {
    return  NurseryFees::withTranslation(app()->getLocale())
      ->whenSearch($request->search)
      ->whenSchool($request->school_id)
      ->WhenSubscription($request->subscription_id)
      ->isActive(true)
      ->with(['school.translations'])
      ->withTranslation(app()->getLocale())
      ->paginate(request()->perPage ?? 20);
  }

  
  public function getNurseryFeesById($nurseryFees)
  {
    $nurseryFees = NurseryFees::findOrFail($nurseryFees);
    return $nurseryFees;
  }

  public function getNurseryFeesRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id','price', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createNurseryFees($request)
  {
    $request_data = $this->getNurseryFeesRequestData($request);

    $nurseryFees = NurseryFees::create($request_data);

    return   $nurseryFees;
  }

  public function updateNurseryFees($request, $nurseryFee)
  {
    $request_data = $this->getNurseryFeesRequestData($request);

    $nurseryFee->update($request_data);

    return true;
  }

  public function deleteNurseryFees($nurseryFees)
  {
    $nurseryFees->delete();
    return true;
  }
}
