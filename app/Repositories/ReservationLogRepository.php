<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use App\Traits\UploadFileTrait;
use App\Interfaces\ReservationLogRepositoryInterface;

class ReservationLogRepository implements ReservationLogRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredReservationLogs($request)
  {
    $logs = ActivityLog::whenSearch($request->search)
      ->whenSchool()
      ->latest()
      ->paginate($request->perPage ?? 50);

    return $logs;
  }
}
