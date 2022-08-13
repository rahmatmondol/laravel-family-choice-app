<?php

namespace App\Http\Requests\Api;

use App\Enums\ReservationStatus;
use Carbon\Carbon;
use App\Models\School;
use App\Models\Reservation;
use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;
use App\Models\Child;
use App\Models\Course;

class ReservationFormRequest extends BaseRequest
{
  public $rules = [];

  protected $stopOnFirstFailure = true;

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'parent_name' => 'required|string|max:255',
      'parent_phone' => 'required|string|max:255',
      'parent_date_of_birth' => ['nullable', 'date', 'before:' . Carbon::now()->subYear(15)->format('Y-m-d'), 'date_format:Y-m-d'],
      'address' => 'required|string|max:255',
      'identification_number' => 'required|string|max:255',
      'course_id' => ['required', 'bail', 'exists:courses,id', function ($attribute, $value, $fail) {
        $course = Course::find($value);
        if ($course->school_id != request()->school_id) {
          $fail(__('site.this course not related to current school'));
        }
      }],
    ];

    if ($this->isMethod('post')) {
      return $this->createRules();
    } elseif ($this->isMethod('put')) {
      return $this->updateRules();
    }
  }

  public function createRules()
  {
    $this->rules += [
      'school_id' => ['required', 'bail', 'exists:schools,id'],
      'child' => ['required'],
      'child.child_name' => ['required', 'string', 'max:255'],
      'child.date_of_birth' => ['required', 'date', 'before:' . Carbon::now()->subYear(2)->format('Y-m-d'), 'date_format:Y-m-d'],
      'child.gender' => ['required', 'in:male,female'],
      'child.grade_id' => ['required', 'exists:grades,id'],
      // 'child.attachments' => ['required', 'array'],
    ];

    $school = School::find(request()->school_id);

    if ($school) {
      foreach (optional($school)->attachments->pluck('id')->toArray() as $attachment_id) {
        $this->rules += ['child.attachments.' . $attachment_id => ['required', 'file']];
      } // end of  for each
    }

    return $this->rules;
  }

  public function updateRules()
  {
    $reservation = Reservation::find(request()->reservation_id);

    $this->rules += [
      'reservation_id' => ['required', 'bail', 'exists:reservations,id', function ($attribute, $value, $fail) use($reservation){
          if ($reservation->status != ReservationStatus::Rejected->value) {
            $fail(__('site.Reservation not rejected so you can not edit reservation now'));
          }
        }],
      'child' => ['required'],
      // 'child.id' => ['required', 'bail', 'exists:children,id', function ($attribute, $value, $fail) {
      //   $child = Child::find($value);
      //   if ($child->school_id != request()->reservation_id) {
      //     $fail('site.this child not related to current reservation');
      //   }
      // }],
      'child.child_name' => ['required', 'string', 'max:255'],
      'child.date_of_birth' => ['required', 'date', 'before:' . Carbon::now()->subYear(2)->format('Y-m-d'), 'date_format:Y-m-d'],
      'child.gender' => ['required', 'in:male,female'],
      'child.grade_id' => ['required', 'exists:grades,id'],
    ];

    // dd($reservation->school->attachments);
    if ($reservation) {
      foreach ($reservation->school->attachments->pluck('id')->toArray() as $attachment_id) {
        $this->rules += ['child.attachments.' . $attachment_id => ['nullable', 'file']];
      } // end of  for each
    }

    // dd($reservation);
    return $this->rules;
  }
}
