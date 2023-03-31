<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum PaymentType: string
{
  use Values;
  case Card    = "card";
  case Wallet  = "wallet";
  case CardAndWallet  = "card_and_wallet";
}
