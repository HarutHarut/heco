<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return Lead[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return  Booking::with('bike.user', 'user')->where('status', 'success')->get();
    }

    /**
     * @var Booking $booking
     */
    public function map($booking): array
    {
        $array = [
            $booking->id,
            $booking->bike->name ?? '',
            $booking->bike->year ?? '',
            $booking->user->name ?? '',
            $booking->city  . ', ' .  $booking->street . ' ' . $booking->house_number  . ', ' . $booking->zip,
            $booking->bike->user->name ?? '',
            $booking->bike->user->city . ', ' . $booking->bike->user->street  . ' ' . $booking->bike->user->house_number . ', ' . $booking->bike->user->zip,
            $booking->price,
            $booking->bike_price,
            $booking->shipping,
            $booking->packaging,
            $booking->pickup_date,
            $booking->created_at,
        ];

        return $array;
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        $array = [
            'ID',
            'Bike',
            'Bike Year',
            'Buyer',
            'Buyer Address',
            'Seller',
            'Seller Address',
            'Price',
            'Bike price',
            'Shipping',
            'Packaging',
            'Pickup Date',
            'Created At'
        ];
        return $array;
    }
}
