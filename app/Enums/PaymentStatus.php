<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum PaymentStatus: string
{
  use Values;
  case Pending   = "pending";
  case Succeeded = "succeeded";
  case Failed = "failed";
  case Refunded = "refunded";
}
