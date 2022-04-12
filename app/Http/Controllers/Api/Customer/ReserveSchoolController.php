<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;

use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Interfaces\AttachmentRepositoryInterface;
use App\Http\Requests\Api\GetSchoolAttachmentFormRequest;
use App\Http\Resources\AttachmentResource;

class ReserveSchoolController  extends Controller
{

  use ResponseTrait;
  public function __construct(
    private AttachmentRepositoryInterface $attachmentRepository,
  ) {
  } //end of constructor

  public function school_attachments(GetSchoolAttachmentFormRequest $request)
  {
    $attachments = $this->attachmentRepository->getAttachments($request);

    return $this->sendResponse(AttachmentResource::collection($attachments), "");
  }
}
