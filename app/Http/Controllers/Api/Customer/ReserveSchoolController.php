<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentResource;
use App\Interfaces\SchoolRepositoryInterface;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Http\Requests\Api\ReserveSchoolFormRequest;
use App\Http\Requests\Api\GetSchoolAttachmentFormRequest;

class ReserveSchoolController  extends Controller
{

  use ResponseTrait;
  public function __construct(
    private SchoolRepositoryInterface $schoolRepository,
    private AttachmentRepositoryInterface $attachmentRepository,
  ) {
  } //end of constructor

  public function school_attachments(GetSchoolAttachmentFormRequest $request)
  {
    $attachments = $this->attachmentRepository->getAttachments($request);

    return $this->sendResponse(AttachmentResource::collection($attachments), "");
  }

  public function reserve_school(ReserveSchoolFormRequest $request)
  {
    $attachments = $this->schoolRepository->reserveSchool($request);

    dd($attachments);
    return $this->sendResponse(AttachmentResource::collection($attachments), "");
  }
}
