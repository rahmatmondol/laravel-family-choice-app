<?php

namespace App\Interfaces;

interface AttachmentRepositoryInterface
{
  public function getFilteredAttachments($request);
  public function getAttachments($request);
  public function getAttachmentById($attachmentId);
  public function createAttachment($request);
  public function updateAttachment($request, $attachment);
  public function deleteAttachment($attachment);
}
