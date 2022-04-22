<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;
use App\Models\Review;

class DeleteReviewFormRequest extends BaseRequest
{

  public $rules = []; // end rules

  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    $this->rules += [
      'review_id' => ['bail', 'required', 'exists:reviews,id', function ($attribute, $value, $fail) {
        $review = Review::find($value);
        if ($review->customer_id != getCustomer()->id) {
          $fail(__('site.this review not related to your account'));
        }
      }],
    ];
    return $this->rules;
  }
}
