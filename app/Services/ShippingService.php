<?php

namespace App\Services;

use App\Models\Bike;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class ShippingService
{
    const LENGTH = 160;
    const WIDTH = 80;
    const HEIGHT = 20;
    const WEIGHT = 20;
    const CARRIER = 'emons';
    const SERVICE = 'sperrgut';

    /**
     * @param $booking
     */
    public static function ship($booking)
    {
        $ch = curl_init();
        $data = [
            'to' => [
                'company' => $booking->user->name,
                'first_name' => $booking->user->first_name,
                'last_name' => $booking->user->last_name,
                'street' => $booking->user->street,
                'street_no' => $booking->user->house_number,
                'city' => $booking->user->city,
                'zip_code' => $booking->user->zip,
                'country' => "DE",
                'phone' => $booking->user->phone,
            ],
            'from' => [
                'company' => $booking->bike->user->name,
                'first_name' => $booking->bike->user->first_name,
                'last_name' => $booking->bike->user->last_name,
                'street' => $booking->bike->user->street,
                'street_no' => $booking->bike->user->house_number,
                'city' => $booking->bike->user->city,
                'zip_code' => $booking->bike->user->zip,
                'country' => "DE",
                'phone' => $booking->bike->user->phone,
            ],
            'package' => [
                'weight' => self::WEIGHT,
                'length' => self::LENGTH,
                'width' => self::WIDTH,
                'height' => self::HEIGHT,
            ],
            'amount_of_lebel' => 1,
            'carrier' => self::CARRIER,
            'service' => self::SERVICE,
            'reference_number' => 'ref' . $booking->id,
            'additional_service' => [
                'goods_insurance' => $booking->bike->price,
                'destination_call' => 1
            ],
            'pickup' => $booking->pickup_date->format('Y-m-d')
        ];
        curl_setopt($ch, CURLOPT_URL, config('services.easy.url') . 'create');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_USERPWD, '' . ':' . config('services.easy.key'));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $result = json_decode($result);
        if (curl_errno($ch)) {
         dd('Error:' . curl_error($ch));
        }
        curl_close($ch);

    }

}
