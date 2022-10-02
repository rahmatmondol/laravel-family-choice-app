<?php

namespace App\Http\Controllers\API\Customer;

use Exception;
use App\Provider;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\NotificationCollection;
use App\Services\NotificationService;

class NotificationController extends Controller
{

  use ResponseTrait;

  public function notificationList()
  {

    return $this->sendResponse(new NotificationCollection(NotificationService::notificationList()), "");
  }

}
