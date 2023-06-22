<?php

namespace App\Http\Requests\Api;

use Carbon\Carbon;
use App\Models\School;
use App\Http\Requests\BaseRequest;
use App\Models\Course;
use App\Models\SubscriptionType;
use App\Models\Transportation;
use Illuminate\Validation\Rule;

class AddReservationFormRequest extends BaseRequest
{
  public $rules = [];

  protected $stopOnFirstFailure = true;

  protected $school;

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->school = School::findOrFail(request()->school_id);
    $course = Course::find(request('child.course_id'));

    $this->rules += [
      'school_id' => ['required', 'bail', 'exists:schools,id'],
      'child' => ['required'],
      'child.child_name' => ['required', 'string', 'max:255'],
      'child.date_of_birth' => ['required', 'date', 'before:' . Carbon::now()->subYear(1)->format('Y-m-d'), 'date_format:Y-m-d'],
      'child.gender' => ['required', 'in:male,female'],
      'parent_name' => 'required|string|max:255',
      'parent_phone' => 'required|string|max:255',
      'parent_date_of_birth' => ['nullable', 'date', 'before:' . Carbon::now()->subYear(15)->format('Y-m-d'), 'date_format:Y-m-d'],
      'address' => 'required|string|max:255',
      'identification_number' => 'required|string|max:255',
      'child.transportation_id' => ['required', 'bail', 'exists:transportations,id', function ($attribute, $value, $fail) {
        $transportation = Transportation::find($value);
        if (isset($transportation) && $transportation->school_id != $this->school->id) {
          $fail(__('site.this transportation not related to current school'));
        }
      }],
      'child.paid_services' => ['nullable', 'array', 'exists:paid_services,id', function ($attribute, $value, $fail) {
        $school_paid_services_ids = $this->school->paidServices()->pluck('id')->toArray();
        if (count(array_diff(array_values($value), array_values($school_paid_services_ids))) != 0) {
          $fail('this services not related to reserved school');
        }
      }],
      'child.grade_id'  => ['nullable', Rule::requiredIf(fn () => $this->school->is_school_type), 'exists:grades,id', function ($attribute, $value, $fail) {
        $school_grades_ids = $this->school->activeGrades->pluck('id')->toArray();
        if (!in_array($value, $school_grades_ids) && $this->school->is_school_type) {
          $fail('this grades not related to reserved school');
        }
      }],
      'child.course_id' => ['nullable', Rule::requiredIf(fn () => $this->school->is_nursery_type), 'exists:courses,id', function ($attribute, $value, $fail) use ($course) {
        if (isset($course) && $course->school_id != $this->school->id && $this->school->is_nursery_type) {
          $fail(__('site.this course not related to current school'));
        }
      }],
      'child.subscription_type_id' => ['nullable', Rule::requiredIf(fn () => $this->school->is_nursery_type), 'exists:subscription_types,id', function ($attribute, $value, $fail) use ($course) {
        $subscription_type = SubscriptionType::find($value);
        if(isset($subscription_type) ){
          if ($subscription_type->school_id != $this->school->id && $this->school->is_nursery_type) {
            $fail(__('site.this subscription type not related to current school'));
          }
          if (isset($course) &&  $course->subscription?->id != $subscription_type->subscription?->id && $this->school->is_nursery_type) {
            $fail(__('site.this subscription type not related to current course'));
          }
        }

      }],
    ];
    if ($this->school) {
      foreach (optional($this->school)->attachments->pluck('id')->toArray() as $attachment_id) {
        $this->rules += ['child.attachments.' . $attachment_id => ['required', 'string']];
      } // end of  for each
    }
    return $this->rules;
  }
}
