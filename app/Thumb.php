<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Thumb {

    /**
     * Get thumb image url
     * 
     * @param $path
     * @param $thumb - thumbtype
     * 
     * @return $url|null
     */ 
    public static function getThumbImageUrl($path, $thumb = "") {
        if(!$path || !$thumb) {
            return false;
        }

        $tbName = explode('.', $thumb);
        if(count($tbName) < 2){
            return false;
        }
        $conf = config('thumbs.'.$tbName[0]);
        $thName = self::getThumbName($path, $conf[$tbName[1]]['postfix']);
        return Storage::exists($thName) ? Storage::url($thName) : null;

    }

    /**
     * Get thumb image according to postfix type
     * 
     * @param $path
     * @param $postfix
     * 
     * @return $tbName
     */
    public static function getThumbImage($path, $postfix) {
        if(!$path || !$postfix){
            return false;
        }

        $arr = explode('/', $path);
        $arr = array_pop($arr);
        $ext = pathinfo($arr, PATHINFO_EXTENSION);

        $tbName = substr($tbName, 0, strpos($tbName, $ext) - 1) . $postfix . '.' . $ext;
        $tbName = implode('', $arr) . '/thumbs/' . $tbName;
        return $tbName;
    }
}

?>