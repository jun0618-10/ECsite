<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;

// class ImageService
// {
//     public static function upload($imageFile, $folderName){

//         $manager = new ImageManager(new Driver());
//         $fileName = uniqid(rand().'_');
//         $extension = strtolower($imageFile->getClientOriginalExtension());
//         $fileNameToStore = $fileName . '.' . $extension;

//         $resizedImage = $manager->read($imageFile->getRealPath())
//             ->resize(1920, 1080);

//         // エンコーダーの選択
//         $encoder = $extension === 'png' ? new PngEncoder() : new JpegEncoder();

//         // エンコード
//         $encodedImage = $resizedImage->encode($encoder);

//         Storage::put('public/' . $folderName . '/' . $fileNameToStore, $encodedImage);

        
//     }

// }

class ImageService
{
    public static function upload($imageFile, $folderName){

        if(is_array($imageFile)){
            $file = $imageFile['image'];
        }else{
            $file = $imageFile;
        }

        $manager = new ImageManager(new Driver());
        $fileName = uniqid(rand().'_');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileNameToStore = $fileName . '.' . $extension;

        $resizedImage = $manager->read($file->getRealPath())
            ->resize(1920, 1080);

        // エンコーダーの選択
        $encoder = $extension === 'png' ? new PngEncoder() : new JpegEncoder();

        // エンコード
        $encodedImage = $resizedImage->encode($encoder);

        Storage::put('public/' . $folderName . '/' . $fileNameToStore, $encodedImage);

        // ファイル名を返す
        return $fileNameToStore;
    }
}