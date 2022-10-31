<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum Status: string
{
  use Values;
  case Active  = '1';
  case InActive = '0';
}
