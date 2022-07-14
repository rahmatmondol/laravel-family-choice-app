<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum ReservationStatus: string
{
  use Values;
  case Pending  = "pending";
  case Accepted = "accepted";
  case Rejected = "rejected";
  // https://github.com/LaravelDaily/Laravel-Constants-Enum-Example/pull/2/files
}
