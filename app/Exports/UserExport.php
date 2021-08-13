<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
     * @return Lead[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        $array = [
            $user->id,
            $user->name,
            $user->email,
            $user->phone,
            $user->country,
            $user->city,
            $user->street,
            $user->house_number,
            $user->zip,
            $user->status,
            $user->email_verified_at,
            $user->created_at,
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
            'Email',
            'Phone',
            'Country',
            'City',
            'Street',
            'House Number',
            'ZIP',
            'Status',
            'Verified At',
            'Created At'
        ];
        return $array;
    }
}
