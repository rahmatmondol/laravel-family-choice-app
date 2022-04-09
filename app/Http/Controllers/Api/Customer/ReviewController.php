<?php

namespace App\Http\Controllers\API\Customer;

use App\Product;

use App\Models\School;
use Illuminate\Http\Request;


use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SetReviewFormRequest;
use App\Http\Resources\Collection\ReviewCollection;
use App\Http\Resources\Collection\SchoolCollection;

class ReviewController  extends Controller
{
  use ResponseTrait;

  public function setReview(SetReviewFormRequest $request)
  {
    $customer = getCustomer();
    $customer->schoolReviews()->updateOrCreate(
      ['school_id' => request('school_id')],
      [
        'follow_up' => request('follow_up'),
        'quality_of_education' => request('quality_of_education'),
        'cleanliness' => request('cleanliness'),
        'comment' => request('comment')
      ]
    );
    $school = School::find(request('school_id'));
    $this->setSchoolTotalReview($school);
    return $this->sendResponse("", "");
  }

  public function setSchoolTotalReview($school)
  {
    $follow_up = $school->schoolReviews()->avg('follow_up');
    $quality_of_education = $school->schoolReviews()->avg('quality_of_education');
    $cleanliness = $school->schoolReviews()->avg('cleanliness');

    $avg = ($follow_up + $quality_of_education + $cleanliness) / 5;

    $school->update([
      'review' => $avg,
    ]);

    $school->update([
      'count_reviews' => $school->schoolReviews()->count(),
    ]);

    return true;
  }

  public function reviewsList(Request $request)
  {
    $schools = getCustomer()->schoolReviews()->latest()->paginate($request->perPage ?? 20);
    return $this->sendResponse(new ReviewCollection($schools), "");
  }
}
