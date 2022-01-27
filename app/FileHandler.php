<?php
namespace App\Helpers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

Class FileHandler {

    private static $tempFolder = 'uploads/images/';

    private static $imageExtensions = ['jpeg', 'png', 'jpg'];

    private static $attachmentExtensions = ['pdf', 'docx'];

    /**
     * Upload image in folder and generate thumbs
     * 
     * @param $image
     * @param $config - configurations
     * @param $folder - folder location
     *
     * @return array 
     */
    public static function imageUpload($image, $config, $folder) {

        $folder = trim($folder, '/');

        $origName = $image->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $mime = $image->getMimeType();
        $origName = substr($origName, 0, strpos($origName, $ext) - 1);

        $path = Storage::putFile($folder, new File($image), 'public');

        if (self::isImage($ext) && $config) {
            $thumbs = config('thumbs.'.$config);
            if ($thumbs && is_array($thumbs)) {
                foreach ($thumbs as $thumb) {
                    self::generateThumbs($path, $thumb, $folder);
                }
            }
        }

        if($path){
            return ['path' => $path, 'name' => $origName, 'ext' => $ext, 'mime' => $mime];
        }

    }

    
    public static function isImage($ext) {
        return in_array($ext, self::$imageExtensions);
    }

    public static function isAttachment($ext) {
        return in_array($ext, self::$attachmentExtensions);
    }

    /**
     * Generate image thumbs
     * 
     * @param $path (main uploaded image path)
     * @param $thumb (configurations)
     * @param $location (folder location)
     * 
     * @return void
     * */ 
    public static function generateThumbs($path, $thumb, $location="") {
        $location .= '/thumbs';
        $dmin = explode('x', $thumb['dimension']);
        $maintainRatio = $thumb['maintain'];
        $image = \Image::make(Storage::get($path));
        if($maintainRatio) {
            $image->resize($dmin[0], $dmin[1], function($constraint){
                $constraint->aspectratio();
                $constraint->upsize();
            });
        } else {
            $image->fit($dim[0], $dim[1], null, 'top-left');
        }

        $imageTb = explode('/', $path);
        $imageTb = array_pop($imageTb);
        $imageTb = explode('.', $imageTb);
        $ext = array_pop($imageTb);

        $imageTb = implode('', $imageTb);
        $imageTb = $imageTb.$thumb['postfix'].'.'.$ext;

        $image->save(public_path(self::$tempFolder . $imageTb));
        $savedImageUri = $image->dirname.'/'.$image->basename;
        Storage::putFileAs($location, new File($savedImageUri), $imageTb, 'public');
        $image->destroy();
        @unlink($savedImageUri);        

    }

    /**
     * Delete imagr form folders
     */
    public static function deleteImage($path, $thumbGroup=false) {
        if(!$path) {
            return false;
        }

        if($thumbGroup) {
            $group = config('thumbs.'.$thumbgroup);
            foreach ($group as $grp) {
                $thumbFile = \App\Helpers\Thumb::getThumbImage($path, $grp['postfix']);
                if (Storage::exists($thumbFile)) {
                    Storage::delete($thumbFile);
                }
            }
        }
        if(Storage::exists($path)) {
            Storage::delete($path);
            return true;
        }
        return false;
    }

}

?>