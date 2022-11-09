<?php

namespace App\Http\Requests\Api;

use App\Enums\ReservationStatus;
use Carbon\Carbon;
use App\Models\School;
use App\Models\Reservation;
use App\Http\Requests\BaseRequest;
use App\Models\Course;
use App\Models\SubscriptionType;
use Illuminate\Validation\Rule;

class ReservationFormRequest extends BaseRequest
{
  public $rules = [];

  protected $stopOnFirstFailure = true;

  protected $school ;

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->school = School::findOrFail(request()->school_id);
    $this->rules += [
      'school_id' => ['required', 'bail', 'exists:schools,id'],
      'parent_name' => 'required|string|max:255',
      'parent_phone' => 'required|string|max:255',
      'parent_date_of_birth' => ['nullable', 'date', 'before:' . Carbon::now()->subYear(15)->format('Y-m-d'), 'date_format:Y-m-d'],
      'address' => 'required|string|max:255',
      'identification_number' => 'required|string|max:255',
      'child.transportation_id' => ['required', 'bail', 'exists:transportations,id'],
      'child.paid_services' => ['nullable','array','exists:paid_services,id',function($attribute, $value, $fail){
        $school_paid_services_ids = $this->school->paidServices()->pluck('id')->toArray();
        if(count(array_diff(array_values($value), array_values($school_paid_services_ids))) != 0){
          $fail('this services not related to reserved school');
        }
      }],
      'child.grade_id'  => [Rule::requiredIf(fn () => $this->school->is_school_type) ,'bail', 'exists:grades,id',function($attribute, $value, $fail){
        $school_grades_ids = $this->school->activeGrades->pluck('id')->toArray();
        if(!in_array($value,$school_grades_ids)){
          $fail('this grades not related to reserved school');
        }
      }],
      'child.course_id' => [Rule::requiredIf(fn () => $this->school->is_nursery_type) ,'bail', 'exists:courses,id', function ($attribute, $value, $fail) {
        $course = Course::find($value);
        if ($course->school_id != request()->school_id) {
          $fail(__('site.this course not related to current school'));
        }
      }],
      'child.subscription_type_id' => [Rule::requiredIf(fn () => $this->school->is_nursery_type) ,'bail', 'exists:subscription_types,id', function ($attribute, $value, $fail) {
        $subscription_type = SubscriptionType::find($value);
        if ($subscription_type->school_id != request()->school_id) {
          $fail(__('site.this subscription type not related to current school'));
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
      'child' => ['required'],
      'child.child_name' => ['required', 'string', 'max:255'],
      'child.date_of_birth' => ['required', 'date', 'before:' . Carbon::now()->subYear(1)->format('Y-m-d'), 'date_format:Y-m-d'],
      'child.gender' => ['required', 'in:male,female'],
    ];

    if ($this->school) {
      foreach (optional($this->school)->attachments->pluck('id')->toArray() as $attachment_id) {
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
    ];

    if ($reservation) {
      foreach ($reservation->school->attachments->pluck('id')->toArray() as $attachment_id) {
        $this->rules += ['child.attachments.' . $attachment_id => ['nullable', 'file']];
      } // end of  for each
    }

    return $this->rules;
  }
}
