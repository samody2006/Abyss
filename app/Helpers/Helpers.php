<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function randomURL($URLlength = 8) {
//        $charray = array_merge(range('a','z'), range('0','9'));
//        $max = count($charray) - 1;
//        for ($i = 0; $i < $URLlength; $i++) {
//            $randomChar = mt_rand(0, $max);
//                    }
//        $url = $charray[$randomChar];
//        return $url;
    }

    public static function generateurl() {
        $url = Storage::disk('public')->temporaryUrl('$image', now()->addMinutes(10));
        return $url;
    }
}
