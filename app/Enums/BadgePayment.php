<?php

namespace App\Enums;

enum BadgePayment: string
{
  case Succeeded = "succeeded";
  case Failed = "danger";
  case Refunded = "warning";
}
