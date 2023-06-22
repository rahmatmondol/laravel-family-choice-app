<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait UploadFileTrait
{
  # upload image
  function uploadImages($req, $path, $deleteOldImage, $meta = null)
  {
    if (!is_dir(public_path('uploads') . '/' . $path)) {
      File::makeDirectory(public_path('uploads/' . $path), 0755, true, true);
    }

    if ($req instanceof  UploadedFile && $req->isValid()) {
      // delete old image
      if ($deleteOldImage != '' && $deleteOldImage != 'default.png') {
        $this->removeImage($deleteOldImage, $path);
      } //end of inner if

      Image::make($req)
        ->save(public_path('uploads/' . $path . $req->hashName()));
      return   $req->hashName();
    }
  }

  function uploadBase64Image($req, $path)
  {
    // dd($req);
    if (!is_dir(public_path('uploads') . '/' . $path)) {
      File::makeDirectory(public_path('uploads/' . $path), 0755, true, true);
    }

    $base64Image = explode(";base64,", $req);
    $explodeImage = explode("image/", $base64Image[0]);
    $imageType = $explodeImage[1];

    $imageName =uniqid().time().rand(1,10000).rand(1,10000).'.'.$imageType;
    Image::make($req)
      ->save(public_path('uploads'.'/' .$path .'/' . $imageName));
    return $imageName;
  }



  #upload image
  function uploadFile($req, $path, $deleteOldFile)
  {

    if (!is_dir(public_path('uploads') . '/' . $path)) {
      File::makeDirectory(public_path('uploads/' . $path), 0755, true, true);
    }

    // dd($req instanceof  UploadedFile ? 'file' : 'not file');
    if ($req instanceof  UploadedFile && $req->isValid()) {
      if ($deleteOldFile != '' && $deleteOldFile != 'default.png') {
        $this->removeImage($deleteOldFile, $path);
      }

      $fileName = time() . rand(1, 100) . '.' . $req->getClientOriginalExtension();

      $req->move(public_path('uploads/' . $path), $fileName);
      return   $fileName;
    }
    return '';
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
  function removeImage($imageName, $folder)
  {
    $DeleteFileWithName = public_path('uploads/' . $folder . '/' . $imageName);

    if ($imageName != 'default.png' && file_exists($DeleteFileWithName)) {
      File::delete($DeleteFileWithName);
    }
  }

  public function deleteAttachments($attachments, $folder)
  {
    foreach ($attachments as $attachment) {
      $attachmentName = $attachment->image;
      $this->removeImage($attachmentName, $folder);
      $attachment->delete();
    }

    return true;
  }

  public function deleteOneAttachment($table, $folder, $id)
  {
    $query = DB::table($table)->where('id', $id);
    $image = $query->first();
    $this->removeImage($image->image, $folder);
    $query->delete();
    return true;
  }
}
