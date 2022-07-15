<?php

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;

return [
  'The selected phone is invalid.' => 'The selected phone is invalid.',
  'The email or phone field is required.' => 'The email or phone field is required.',
  'Password not correct' => 'Password not correct',
  'User not found' => 'User not found',
  'User already verified' => 'User already verified',
  'Successfully logged out' => 'Successfully logged out',
  'Unauthenticated' => 'Unauthenticated',
  'Old password not correct' => 'Old password not correct',
  'Confirm the phone first.' => 'Confirm the phone first.',
  'User not verified' => 'User not verified',
  'you can not review this school' => 'you can not review this school',
  'reservation_status' => [
    ReservationStatus::Pending->value => 'Pending',
    ReservationStatus::Accepted->value => 'Accepted',
    ReservationStatus::Rejected->value => 'Rejected',
  ],
  'payment_status' => [
    PaymentStatus::Pending->value => 'Pending',
    PaymentStatus::Succeeded->value => 'Succeeded',
    PaymentStatus::Failed->value => 'Failed',
    PaymentStatus::Refunded->value => 'Refunded',
  ],
  'this course not related to current school' => 'this course not related to current school',
  'this child not related to current reservation' => 'this child not related to current reservation',
  'pending_reservation_body' => 'The reservation has been successfully booked, and the data and attachments will be reviewed by the school administration and contact you as soon as possible',
  'accepted_reservation_body' => 'The reservation data has been approved by the school administration. You can make the payment now to complete the reservation process',
  'rejected_reservation_body' => '',
  'Total' => 'Total',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
];
