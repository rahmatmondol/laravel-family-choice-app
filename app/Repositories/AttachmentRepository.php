<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Scopes\OrderScope;
use App\Traits\UploadFileTrait;
use App\Interfaces\AttachmentRepositoryInterface;

class AttachmentRepository implements AttachmentRepositoryInterface
{
  use UploadFileTrait;

  public function getFilteredAttachments($request)
  {
    return  Attachment::withoutGlobalScope(new OrderScope)
      ->whenSearch($request->search)
      ->isActive($request->status)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAttachments($request)
  {
    return  Attachment::whenSearch($request->search)
      ->whenSchool()
      ->isActive(true)
      ->latest()
      ->paginate(request()->perPage ?? 20);
  }

  public function getAttachmentById($attachmentId)
  {
    $attachment = Attachment::findOrFail($attachmentId);
    return $attachment;
  }

  public function getAttachmentRequestData($request)
  {
    $request_data = array_merge(['status', 'school_id', 'type', 'from_date', 'to_date', 'order_column'], config('translatable.locales'));

    return  $request->only($request_data);
  }

  public function createAttachment($request)
  {
    $request_data = $this->getAttachmentRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'attachments/', '', '');
    } //end of if

    $attachment = Attachment::create($request_data);

    return   $attachment;
  }

  public function updateAttachment($request, $attachment)
  {
    $request_data = $this->getAttachmentRequestData($request);

    if ($request->image) {
      $request_data['image'] = $this->uploadImages($request->image, 'attachments/', $attachment->image);
    } //end of if

    $attachment->update($request_data);

    return true;
  }

  public function deleteAttachment($attachment)
  {
    $this->removeImage($attachment->image, 'attachments');
    $attachment->delete();
    return true;
  }
}
