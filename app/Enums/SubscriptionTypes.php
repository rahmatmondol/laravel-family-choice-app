<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum SubscriptionTypes: string
{
  use Values;
  case PartTime   = "part_time";
  case FullTime   = "full_time";
}
