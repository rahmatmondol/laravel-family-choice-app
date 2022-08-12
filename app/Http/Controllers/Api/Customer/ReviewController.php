<?php

namespace App\Http\Controllers\API\Customer;

use App\Product;

use App\Models\School;
use Illuminate\Http\Request;


use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SetReviewFormRequest;
use App\Http\Requests\Api\DeleteReviewFormRequest;
use App\Http\Resources\Collection\ReviewCollection;
use App\Http\Resources\Collection\SchoolCollection;
use App\Models\Review;

class ReviewController  extends Controller
{
  use ResponseTrait;

  public function setReview(SetReviewFormRequest $request)
  {
    $customer = getCustomer();
    $avg = (request('follow_up') + request('quality_of_education') + request('cleanliness'))/ 3;
    $customer->reviews()->updateOrCreate(
      ['school_id' => request('school_id')],
      [
        'follow_up' => request('follow_up'),
        'quality_of_education' => request('quality_of_education'),
        'cleanliness' => request('cleanliness'),
        'avg' => $avg,
        'comment' => request('comment')
      ]
    );
    $school = School::find(request('school_id'));
    $this->setSchoolTotalReview($school);
    return $this->sendResponse("", "");
  }

  public function setSchoolTotalReview($school)
  {
    $follow_up = $school->reviews()->avg('follow_up');
    $quality_of_education = $school->reviews()->avg('quality_of_education');
    $cleanliness = $school->reviews()->avg('cleanliness');

    $avg = ($follow_up + $quality_of_education + $cleanliness) / 3;

    $school->update([
      'review' => $avg,
    ]);

    $school->update([
      'count_reviews' => $school->reviews()->count(),
    ]);

    return true;
  }

  public function reviewsList(Request $request)
  {
    $reviews = getCustomer()->reviews()->latest()->paginate($request->perPage ?? 20);
    return $this->sendResponse(new ReviewCollection($reviews), "");
  }


  public function deleteReview(DeleteReviewFormRequest $request)
  {
    Review::find(request('review_id'))->delete();
    return $this->sendResponse("", "");
  }
}
