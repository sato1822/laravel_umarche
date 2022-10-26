<?php 

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
  public static function upload($imageFile, $folderName)//staticとすることで他のクラスでもつかうことができる
  {
    // dd($imageFile['image']);
    if(is_array($imageFile))
    {
      $file = $imageFile['image'];
    } else{
      $file = $imageFile;
    }

    $filename = uniqid(rand(), '_');
    $extension = $file->extension();
    $fileNameToStore = $filename . '.' . $extension;
    $resizedImage = InterventionImage::make($file)->resize(1920, 1080)->encode();
    // dd($imageFile, $resizedImage);

    Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);
    return $fileNameToStore;
  }
}