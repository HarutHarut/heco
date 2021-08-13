<?php

namespace App\Exports;

use App\Models\Bike;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BikeExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return Lead[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return Bike::where('parent_id', '0')->where(function ($q) {
            $q->where('request', 0)
                ->orWhere(function ($q) {
                    $q->where('request', 1)->where('send_request', 1);
                });
        })->whereNotIn('status', ['deleted', 'pending'])->with('brand', 'model')->withCount('views')->get();
    }

    /**
     * @var Bike $bike
     */
    public function map($bike): array
    {
        $array = [
            $bike->id,
            $bike->name,
            $bike->brand->name ?? '',
            $bike->model->name ?? '',
            $bike->year,
            $bike->price,
            $bike->msrp,
            $bike->status,
            $bike->is_sold,
            $bike->views_count,
            $bike->created_at,
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
            'Name',
            'Brand',
            'Model',
            'Year',
            'Price',
            'MSRP',
            'Status',
            'is Sold',
            'Views',
            'Created At'
        ];
        return $array;
    }
}
