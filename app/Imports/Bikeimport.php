<?php

namespace App\Imports;

use App\Models\Bike;
use App\Models\BikeCategory;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Services\DataService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Bikeimport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $array = [
            'frame_material' => 1,
            'fork_material' => 2,
            'brake_levers' => 3,
            'brake_type' => 4,
            'component_group_general' => 5,
            'component_group' => 6,
            'frame' => 7,
            'fork' => 8,
            'tires' => 9,
            'cassette' => 10,
            'seatpost' => 11,
            'handlebar' => 12,
            'diskrotors' => 13,
            'chainrings' => 14,
            'saddle' => 15,
            'wheels' => 16,
            'crank' => 17,
            'stem' => 18,
            'brakes' => 19,
            'chain' => 20,
            'shifters' => 21,
            'rearderailleur' => 22,
            'headset' => 23,
            'bottombracket' => 24,
            'frontderailleur' => 25,
            'pedals' => 26,
            'fronthub' => 27,
            'rearhub' => 28,
            'grips' => 29,
            'brakelevers' => 30,
            'rearshock' => 31,
            'motor' => 32,
            'battery' => 33,
            'charger' => 34,
            ];
        $i = 1;
        foreach ($collection as $row)
        {
            $slug = DataService::getSlug($row['bike_id']);
            $brand = Brand::updateOrCreate([
                'name' => $row['manufacturer'],
            ]);
            $model = BrandModel::updateOrCreate([
                'brand_id' => $brand->id,
                'name' => $row['model'],
            ]);
            $bike = Bike::updateOrCreate([
                'brand_id' => $brand->id,
                'brand_model_id' => $model->id,
                'year' => $row['year'] ?: date('Y'),
            ], [
                'name' => $row['bike_id'],
                'msrp' => $row['msrp'] ? (double)$row['msrp'] : null,
                'price' => $row['msrp'] ? (double)$row['msrp'] : null,
                'wheels_size' => $row['wheels_size'] ? (double)$row['wheels_size'] : null,
                'weight' => $row['weight'] ? (double)$row['weight'] : null,
                'image_path' => $row['image_url'],
                'slug' => $slug,
                'description' => ['en' => $row['description']],
                'msrp_currency' => 'EUR',
                'parent_id' => 1,
                'country_id' => 1,
                'status' => 'active',
                'user_id' => 1,
                'request' => 0,
            ]);

            foreach ($array as $key => $value){
                BikeSetting::updateOrCreate([
                    'bike_id' => $bike->id,
                    'detail_id' => $value
                ], [
                    'value' => $row[$key]
                ]);
            }

            if ($row['category_1']) {
                $cat1 = Category::query()->updateOrCreate([
                    'name' => $row['category_1'],
                    'status' => 1
                ]);

                BikeCategory::query()->create([
                    'bike_id' => $bike->id,
                    'category_id' => $cat1->id,
                ]);
            }
            if ($row['category_2']) {
                $cat2 = Category::query()->updateOrCreate([
                    'name' => $row['category_2'],
                    'status' => 1
                ]);

                BikeCategory::query()->create([
                    'bike_id' => $bike->id,
                    'category_id' => $cat2->id,
                ]);
            }
        }
    }
}
