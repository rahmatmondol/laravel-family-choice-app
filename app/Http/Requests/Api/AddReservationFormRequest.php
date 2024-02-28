<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseTrait;
use Carbon\Carbon;
use App\Models\School;
use App\Http\Requests\BaseRequest;
use App\Models\Course;
use App\Models\SubscriptionType;
use App\Models\Transportation;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddReservationFormRequest extends FormRequest
{
    use ResponseTrait;

    protected $school;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->school = School::find($this->input('school_id'));

        return [
            'school_id' => ['required', 'exists:schools,id'],
            'document_id'=> ['required','exists:custoemr_documents,id'],
            'child' => ['required', 'array'],
            'child.child_name' => ['required', 'string', 'max:255'],
            'child.date_of_birth' => [
                'required',
                'date',
                'before:' . Carbon::now()->subYear(1)->format('Y-m-d'),
                'date_format:Y-m-d'
            ],
            'child.gender' => ['required', 'in:male,female'],
            'parent_name' => ['required', 'string', 'max:255'],
            'parent_phone' => ['required', 'string', 'max:255'],
            'parent_date_of_birth' => [
                'nullable',
                'date',
                'before:' . Carbon::now()->subYear(15)->format('Y-m-d'),
                'date_format:Y-m-d'
            ],
            'address' => ['required', 'string', 'max:255'],
            'identification_number' => ['required', 'string', 'max:255'],
            'child.transportation_id' => ['required', 'exists:transportations,id'],
            'child.paid_services' => ['nullable', 'array'],
            'child.paid_services.*' => ['exists:paid_services,id'],
            'child.grade_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return $this->school && $this->school->is_school_type;
                }),
                'exists:grades,id'
            ],
            'child.course_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return $this->school && $this->school->is_nursery_type;
                }),
                'exists:courses,id'
            ],
            'child.subscription_type_id' => [
                'nullable',
                Rule::requiredIf(function () {
                    return $this->school && $this->school->is_nursery_type;
                }),
                'exists:subscription_types,id'
            ],
            'child.attachments' => $this->getAttachmentRules(),

        ];
    }

    protected function getAttachmentRules()
    {
        $attachmentRules = [];
        if ($this->school) {
            foreach ($this->school->attachments as $attachment) {
                $attachmentRules['child.attachments.' . $attachment->id] = ['required', 'string'];
            }
        }
        return $attachmentRules;
    }
}
