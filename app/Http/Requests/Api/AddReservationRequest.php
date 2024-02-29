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
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:255',
            'parent_date_of_birth' => 'nullable|date_format:Y-m-d',
            'address' => 'required|string|max:255',
            'document_id' => 'required|integer',
            'school_id' => 'required|integer',
            'Children_name' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Children_birth_certificate' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Children_health_card' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

//            'total_fees' => 'nullable|numeric',
//            'reason_of_refuse' => 'nullable|string',
//            'partial_payment_info' => 'nullable|array',
//            'remaining_payment_info' => 'nullable|array',
//            'refund_partial_payment_info' => 'nullable|array',
            'status' => 'string|in:pending,accepted,rejected',
            'payment_status' => 'string|in:pending,succeeded,failed',
            'identification_number' => 'required|string|max:255',
        ];
    }
}
