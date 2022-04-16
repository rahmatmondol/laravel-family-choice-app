<?php

namespace App\Http\Requests\Api;

use App\Models\School;
use App\Models\Reservation;
use App\Rules\CheckEmailExist;
use App\Http\Requests\BaseRequest;

class ReservationFormRequest extends BaseRequest
{
  public $rules = [];

  public function authorize()
  {
    return true;
  }
  public function rules()
  {
    $this->rules += [
      'parent_name' => 'required|string|max:255',
      'address' => 'required|string|max:255',
      'identification_number' => 'required|string|max:255',
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
      'children' => ['required', 'array'],
      'children.*.child_name' => ['required', 'string', 'max:255'],
      'children.*.date_of_birth' => ['required', 'date', 'before:yesterday', 'date_format:Y-m-d'],
      'children.*.gender' => ['required', 'in:male,female'],
      'children.*.grade_id' => ['required', 'exists:grades,id'],
      'children.*.attachments' => ['required', 'array'],
    ];

    $school = School::find(request()->school_id);

    // dd($school->attachments->pluck('id')->toArray());
    foreach ($school->attachments->pluck('id')->toArray() as $attachment_id) {
      $this->rules += ['children.*.attachments.*.' . $attachment_id => ['required']];
    } // end of  for each

    // dd($this->rules);
    return $this->rules;
  }

  public function updateRules()
  {
    $this->rules += [
      'reservation_id' => ['required', 'bail', 'exists:reservations,id'],
      'children' => ['required', 'array'],
      'children.*.child_name' => ['required', 'string', 'max:255'],
      'children.*.date_of_birth' => ['required', 'date', 'before:yesterday', 'date_format:Y-m-d'],
      'children.*.gender' => ['required', 'in:male,female'],
      'children.*.attachments' => ['nullable', 'array'],
    ];

    $reservation = Reservation::find(request()->reservation_id);
    $school = School::find($reservation->school_id);
    $children_ids = $reservation->children->pluck('id');
    foreach ($school->attachments->pluck('id')->toArray() as $attachment_id) {
      $this->rules += ['children.*.attachments.*.' . $attachment_id => ['nullable']];
      $this->rules += ['children.*.child_id'  => ['required', 'exists:children,id']];
      // $this->rules += ['children.*.child_id'  => ['required', 'exists:children,id', 'in:' . $children_ids]];
    } // end of  for each

    // dd($this->rules);
    return $this->rules;
  }
}
