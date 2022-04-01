<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait UploadFileTrait
{

  #upload image
  function uploadImages($req, $path, $deleteOldImage, $meta = null)
  {
    // delete old image
    if ($deleteOldImage != '' && $deleteOldImage != 'default.png') {
      $this->removeImage($deleteOldImage, $path);
    } //end of inner if

    Image::make($req)
      ->save(public_path('uploads/' . $path . $req->hashName()));
    return   $req->hashName();
  }

  #upload image
  function uploadFile($req, $path, $deleteOldFile)
  {
    if ($deleteOldFile != '' && $deleteOldFile != 'default.png') {
      $this->removeImage($deleteOldFile, $path);
    }

    $fileName = time() . rand(1, 100) . '.' . $req->getClientOriginalExtension();

    $req->move(public_path('uploads/' . $path), $fileName);
    return   $fileName;
  }

  // #multiple upload image
  function MultipleUploadImages($requests, $path)
  {

    $data = [];
    foreach ($requests as  $attach) {

      Image::make($attach)
        ->save(public_path('uploads/' . $path . $attach->hashName()));
      $data[] = $attach->hashName();
    }
    return $data;
  }

  // delete main image for model
  function removeImage($imageName, $path)
  {

    $DeleteFileWithName = public_path('uploads/' . $path . '/' . $imageName);

    if ($imageName != 'default.png' && file_exists($DeleteFileWithName)) {
      File::delete($DeleteFileWithName);
    }
  }


  public function deleteAttachments($table, $folder, $column, $id)
  {

    $attachments = DB::table($table)->where($column, $id)->get();
    foreach ($attachments as $attachment) {
      $this->removeImage($attachment->image, $folder);
    }
    $attachment->delete();

    return true;
  }
}
