<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ImagesService
{
    public static function savePhoto($image, $path, $repo = 'public')
    {
        $publicDisk = Storage::disk($repo);
        $imageFileName = rand(1000000, 99999999999) . Str::slug($image->getClientOriginalName(), '.');
        $filePath = $path . '/' . $imageFileName;
        $publicDisk->put($filePath, file_get_contents($image), 'public');

        self::attachmentThumb($image, $path, $imageFileName, [210, 400, 700], 'public');
        return $imageFileName;
    }

    /**
     * @param $input
     * @param $name
     * @param $widths
     * @param null $repo
     */
    public static function attachmentThumb($input, $path, $name, $widths, $repo = null)
    {
        set_time_limit(100000000);
        foreach ($widths as $width) {
            self::attachment($input, $path, $name, $repo, $width);
        }
    }

    /**
     * @param $input
     * @param $name
     * @param $repo
     * @param $width
     */
    public static function attachment($input, $path, $name, $repo, $width)
    {
        try {
            $img = Image::make($input)->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            })->response();
            $s3 = Storage::disk('public');
            $filePath = "$path/thumb/$width/" . $name;
            $s3->put($filePath, $img->getContent(), 'public');

        } catch (\Exception $e) {}
    }


    /**
     * @param $image
     * @param $object
     * @param $path
     * @param string $field
     */
    public static function saveCropImage($image, $object, $path, $field = 'image')
    {
        $disk = Storage::disk('public');
        $disk->delete($path . '/'. $object->image_path);
        $data = explode(',', $image);
        $img_string = $data[1];
        $fileName = time() . rand(1000000, 9999999) . '.jpg';
        $filePath = '/' . $path . '/' . $fileName;
        $storage = Storage::disk('public');
        $storage->put($filePath, base64_decode($img_string), 'public');
        $object->$field = $fileName;
        $object->save();
    }

}
