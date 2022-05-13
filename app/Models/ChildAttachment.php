<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildAttachment extends Model
{
  use HasFactory;
  protected $guarded = [];
  public function getAttachmentFilePathAttribute()
  {
    return asset('uploads/child_attachments/' . $this->attachment_file);
  } //end of image path attribute

  public function child()
  {
    return $this->belongsTo(Child::class, 'child_id', 'id');
  }

  public function attachment()
  {
    return $this->belongsTo(Attachment::class);
  }
}
