<?php

namespace App\Enums;

enum ReservationStatus: string
{
  case Pending   = "pending";
  case Accepted = "accepted";
  case Rejected = "rejected";
  // https://github.com/LaravelDaily/Laravel-Constants-Enum-Example/pull/2/files
}
