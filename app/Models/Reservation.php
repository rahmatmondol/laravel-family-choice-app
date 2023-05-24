<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\ReservationStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];

  protected static $logAttributes = ['status', 'payment_status', 'reason_of_refuse'];
  protected $casts = [
    'partial_payment_info' => 'array',
    'remaining_payment_info' => 'array',
    'refund_partial_payment_info' => 'array',
    'payment_notification' => 'array',
  ];

  protected static $logOnlyDirty = true;

  ##########################  start partial payment info  ###########################
  public function getPartialPaymentOptionsAttribute()
  {
    $options = [];
    if ($this->status == ReservationStatus::Pending->value && $this->required_payment_step_is_partial) {
      $required_partial_payment_amount = $this->required_partial_payment_amount;
      $available_amount_in_wallet = getCustomer()->wallet;
      $options[PaymentType::Card->value] = $required_partial_payment_amount;
      if ($available_amount_in_wallet > 0) {
        if ($required_partial_payment_amount <= $available_amount_in_wallet) {
          $options[PaymentType::Wallet->value] =  $required_partial_payment_amount;
        } else {
          $options[PaymentType::CardAndWallet->value] = [
            PaymentType::Wallet->value => [
              'amount' =>  (int)$available_amount_in_wallet,
            ],
            PaymentType::Card->value => [
              'amount' =>  $required_partial_payment_amount  - $available_amount_in_wallet,
            ],
          ];
        }
      }
    }
    return count($options) ? $options : null;
  }
  // amount
  public function getRequiredPartialPaymentAmountAttribute()
  {
    return  (setting('partial_payment_percent') / 100) * $this->total_fees;
  }
  // amount
  public function getRequiredAmountToPayWithCardAttribute()
  {
    if ($this->required_payment_step_is_partial) {
      return $this->required_partial_payment_amount * 100;
    } else if ($this->required_payment_step_is_remaining) {
      return $this->required_remaining_payment_amount * 100;
    } else {
      throw new Exception("Partial and remaining payment steps are done");
    }
  }
  // condition
  public function getRequiredPaymentStepIsPartialAttribute()
  {
    return empty($this->partial_payment_info)  ||
      (isset($this->partial_payment_info) && $this->partial_payment_info['status'] == 'pending')
      ? true : false;
  }
  public function getPartialPaymentIntentIdAttribute()
  {
    $payment_intent_id = '';
    if ($this->partial_payment_info) {
      if ($this->partial_payment_info['type'] == PaymentType::CardAndWallet->value) {
        $payment_intent_id = $this->partial_payment_info['card']['payment_intent_id'];
      } elseif ($this->partial_payment_info['type'] == PaymentType::Card->value) {
        $payment_intent_id = $this->partial_payment_info['payment_intent_id'];
      }
    }
    return $payment_intent_id;
  }

  ##########################  end partial payment info  ###########################

  ##########################  start refund partial payment info  ###########################
  public function getCanRefundPartialPaymentAttribute()
  {
    return $this->payment_status != PaymentStatus::Succeeded->value && (isset($this->partial_payment_info) &&  $this->partial_payment_info['status'] == 'done')
      ? true : false;
    // return  $this->required_payment_step_is_remaining  && empty($this->refund_partial_payment_info) ? true : false;
  }

  public function getAmountRefundedToCardInPartialPaymentAttribute()
  {
    $amount = 0;
    if ($this->can_refund_partial_payment) {
      if ($this->partial_payment_info) {
        if ($this->partial_payment_info['type'] == PaymentType::Card->value) {
          $amount = $this->partial_payment_info['amount'] - ($this->partial_payment_info['amount'] * (setting('refund_fees_percent') / 100));
        }
        if ($this->partial_payment_info['type'] == PaymentType::CardAndWallet->value) {
          $amount =  $this->partial_payment_info[PaymentType::Card->value]['amount'] - ($this->partial_payment_info[PaymentType::Card->value]['amount'] * (setting('refund_fees_percent') / 100));
        }
      }
    }
    return $amount;
  }

  public function getRefundPartialPaymentOptionsAttribute()
  {
    $options = [];
    if ($this->can_refund_partial_payment) {
      if ($this->partial_payment_info) {
        $options['status'] = "pending";
        if ($this->partial_payment_info['type'] == PaymentType::Card->value) {
          $options['type']   = PaymentType::Card->value;
          $options['amount'] = $this->amount_refunded_to_card_in_partial_payment;
        }
        if ($this->partial_payment_info['type'] == PaymentType::Wallet->value) {
          $options['type']   = PaymentType::Wallet->value;
          $options['amount'] = $this->partial_payment_info['amount'];
        }
        if ($this->partial_payment_info['type'] == PaymentType::CardAndWallet->value) {
          $options['type']   = PaymentType::CardAndWallet->value;
          $options[PaymentType::CardAndWallet->value][PaymentType::Wallet->value]['amount'] = $this->partial_payment_info[PaymentType::Wallet->value]['amount'];
          $options[PaymentType::CardAndWallet->value][PaymentType::Wallet->value]['status'] = 'pending';
          $options[PaymentType::CardAndWallet->value][PaymentType::Card->value]['amount'] =  $this->amount_refunded_to_card_in_partial_payment;
          $options[PaymentType::CardAndWallet->value][PaymentType::Card->value]['status'] = 'pending';
        }
      }
    }
    return count($options) ? $options : null;
  }
  ##########################  end refund partial payment info  ###########################

  ########################## start  remaining payment info  ###########################
  public function getRemainingPaymentOptionsAttribute()
  {
    $options = [];
    if ($this->status == ReservationStatus::Accepted->value && $this->required_payment_step_is_remaining) {
      $required_remaining_payment_amount = $this->required_remaining_payment_amount;
      $available_amount_in_wallet = getCustomer()->wallet;
      $options[PaymentType::Card->value] = $required_remaining_payment_amount;
      if ($available_amount_in_wallet > 0) {
        if ($required_remaining_payment_amount <= $available_amount_in_wallet) {
          $options[PaymentType::Wallet->value] = $required_remaining_payment_amount;
        } else {
          $options[PaymentType::CardAndWallet->value] = [
            PaymentType::Wallet->value => [
              'amount' =>  $available_amount_in_wallet,
            ],
            PaymentType::Card->value => [
              'amount' =>  $required_remaining_payment_amount  - $available_amount_in_wallet,
            ],
          ];
        }
      }
    }
    return count($options) ? $options : null;
  }
  // amount
  public function getRequiredRemainingPaymentAmountAttribute()
  {
    return $this->total_fees - $this->required_partial_payment_amount;
  }
  // condition
  public function getRequiredPaymentStepIsRemainingAttribute()
  {
    return  isset($this->partial_payment_info) && $this->partial_payment_info['status'] == 'done' &&
      (empty($this->remaining_payment_info)  || (isset($this->remaining_payment_info) && $this->remaining_payment_info['status'] == 'pending'))
      ? true : false;
  }
  public function getRemainingPaymentIntentIdAttribute()
  {
    $payment_intent_id = '';
    if ($this->remaining_payment_info) {
      if ($this->remaining_payment_info['type'] == PaymentType::CardAndWallet->value) {
        $payment_intent_id = $this->remaining_payment_info['card']['payment_intent_id'];
      } elseif ($this->remaining_payment_info['type'] == PaymentType::Card->value) {
        $payment_intent_id = $this->remaining_payment_info['payment_intent_id'];
      }
    }
    return $payment_intent_id;
  }



  ########################## end  remaining payment info  ###########################



  public function scopeWhenSearch($query, $search)
  {
    return $query->when($search, function ($q) use ($search) {
      return $q->where('parent_name', 'like', "%$search%")
        ->orWhere('id', $search);
    });
  } // end of scopeWhenSearch

  public function scopeWhenStatus($query, $status)
  {
    return $query->when($status, function ($q) use ($status) {
      return $q->where('status', $status);
    });
  } // end of scopeWhenStatus

  public function scopeWhenPaymentStatus($query, $status)
  {
    return $query->when($status, function ($q) use ($status) {
      return $q->where('payment_status', $status);
    });
  } // end of scopeWhenPaymentStatus

  public function scopeWhenSchool($query, $school_id)
  {
    $school_id = getAuthSchool() ? getAuthSchool()->id : $school_id;
    return $query->when($school_id, function ($q) use ($school_id) {

      return $q->whereHas('school', function ($qu) use ($school_id) {

        return $qu->where('school_id', $school_id);
      });
    });
  } // end of

  public function scopeWhenCourse($query, $course_id)
  {
    return $query->when($course_id, function ($q) use ($course_id) {

      return $q->whereHas('course', function ($qu) use ($course_id) {

        return $qu->where('course_id', $course_id);
      });
    });
  } // end of

  public function scopeWhenCustomer($query, $customer_id)
  {
    return $query->when($customer_id, function ($q) use ($customer_id) {

      return $q->whereHas('customer', function ($qu) use ($customer_id) {

        return $qu->where('customer_id', $customer_id);
      });
    });
  } // end of

  public function scopeWhenFromDate($query, $from_date)
  {
    return $query->when($from_date, function ($q) use ($from_date) {
      return $q->whereDate('created_at', '>=', $from_date);
    });
  } // end of

  public function scopeWhenToDate($query, $to_date)
  {
    return $query->when($to_date, function ($q) use ($to_date) {
      return $q->whereDate('created_at', '<=', $to_date);
    });
  } // end of

  ////////////////// start relationships //////////////////////////////
  public function customer()
  {
    return $this->belongsTo(Customer::class);
  }

  public function school()
  {
    return $this->belongsTo(School::class);
  }

  public function course()
  {
    return  $this->belongsTo(Course::class);
  }

  public function grade()
  {
    return  $this->belongsTo(Grade::class);
  }

  public function child()
  {
    return $this->hasOne(Child::class);
  }

  public function paidServices()
  {
    return $this->belongsToMany(PaidService::class, 'reservation_paid_service', 'reservation_id', 'paid_service_id')->withTranslation(app()->getLocale())->withPivot(['price']);
  }

  public function nurseryFees()
  {
    return $this->belongsToMany(NurseryFees::class, 'reservation_nursery_fees', 'reservation_id', 'nursery_fees_id')->withTranslation(app()->getLocale())->withPivot(['price']);
  }

  public function gradeFees()
  {
    return $this->belongsToMany(GradeFees::class, 'reservation_grade_fees', 'reservation_id', 'grade_fees_id')->withTranslation(app()->getLocale())->withPivot(['price']);
  }
  ////////////////// end relationships //////////////////////////////


}
