<?php

namespace App\Services;

use App\Models\Bike;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class DataService
{
    public static function getSlug($name)
    {
        $slug = Str::slug($name);
        $rows = Bike::whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get();
        $count = count($rows) + 1;
        return ($count > 1) ? "{$slug}-{$count}" : $slug;
    }

    public static function saveData($requestData, $object, $dataObject)
    {
        $fillableArray = array_flip($dataObject->getFillable());
        $langs = LaravelLocalization::getSupportedLocales();
        foreach ($langs as $localeCode => $properties) {
            $dataToFind = [];
            $data = [];
            foreach ($fillableArray as $key => $value) {
                if ($key == $dataObject->foreignKey) {
                    $dataToFind[$key] = $object->id;
                } elseif ($key == 'lang') {
                    $dataToFind[$key] = $localeCode;
                } else {
                    $requestDataKey = $key . '_' . $localeCode;
                    $data[$key] = $requestData[$requestDataKey];
                }
            }
            $dataObject::updateOrCreate($dataToFind, $data);
        }
        return $data;
    }


}
