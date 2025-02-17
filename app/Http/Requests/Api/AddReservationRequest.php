<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class AddReservationRequest extends FormRequest
{
    use ResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'parent_Name'=>'required|string',
//            'parent_name' => 'required|string|max:255',
            'parent_Phone' => 'required|string|max:255',
            'parent_Date_of_birth' => 'required|nullable|date_format:Y-m-d',
            'parent_Address' => 'required|string|max:255',
            'folderId' => 'required|integer',
            'schoolId' => 'required|integer',
            'child_name' => 'required|string|max:255',
            'child_photo' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_birth_certificate' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_health_card' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'child_date_of_birth' => 'required|date|date_format:Y-m-d',
            'child_gender' => 'required|in:male,female',
            'status' => 'string|in:pending,accepted,rejected',
            'payment_status' => 'string|in:pending,succeeded,failed',
            'identification_Number' => 'required|string|max:255',
        ];
    }
}
