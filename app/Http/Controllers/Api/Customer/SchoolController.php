<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\SchoolRepositoryInterface;
use App\Http\Resources\Collection\SchoolCollection;

class SchoolController extends Controller
{
  use ResponseTrait;

  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
  ) {
  } //end of constructor

  public function schools(Request $request)
  {
    $schools = $this->schoolRepository->getSchools($request);
    return $this->sendResponse(new SchoolCollection($schools), "");
  }
}
