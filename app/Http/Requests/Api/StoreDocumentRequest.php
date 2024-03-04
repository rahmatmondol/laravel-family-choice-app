<?php

namespace App\Http\Requests\Api;

use App\Traits\ResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'title'=>'required|string',
            'back_side' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'front_side' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
