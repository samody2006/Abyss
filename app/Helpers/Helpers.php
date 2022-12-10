<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;

class Helpers
{
    function photoType($photo) {
        if(@is_string($photo)) {
            try {
                $image_data = preg_replace('#^data:application/\w+;base64,#i', '', $photo);
                $decode_image = base64_decode($image_data);

                if(!imagecreatefromstring($decode_image)) {
                    return false;
                }
                return "Base64";
            } catch(ErrorException $e) {
                return false;
            }
        }

        return @is_file($photo) ? "file" : false;
    }

    function uploadImage($dir, $photo) {
        $photo_type = photoType($photo);

        if(!$photo_type) {
            return null;
        }

        if($photo_type == "Base64") {
            try {
                $name = time(). rand(1,10) . '.' . explode('/', explode(':', substr($photo, 0, strpos($photo, ';')))[1])[1];
            } catch(ErrorException $e) {
                $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
                $f = finfo_open();
                $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);
                $extension =  substr($mime_type, (strpos($mime_type, "/") + 1));
                $name = time() . rand(1,10) . '.' . $extension;
            }

            $image = \Image::make($photo)->stream();
            Storage::put($dir . $name, $image);
            // ->save(storage_path('images/shop/').$name);
            return $dir . $name;

        }

        if($photo_type == "file") {
            $imageName = time(). rand(1,10) . '.' . $photo->getClientOriginalExtension();
            $newImage = \Image::make($photo->getRealPath());
            Storage::put($dir . $imageName, $newImage->stream());
            return $dir . $imageName;
        }

        return null;
    }
}
