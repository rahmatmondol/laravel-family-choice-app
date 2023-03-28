<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum PaymentStep: string
{
  use Values;
  case PartialPayment    = "partial_payment";
  case RemainingPayment  = "remaining_payment";
}
