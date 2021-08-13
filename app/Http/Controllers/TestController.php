<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\BikeCategory;
use App\Models\BikeSetting;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Component;
use App\Models\Detail;
use App\Models\Manufacturer;
use App\Services\DataService;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Schema;


class TestController extends Controller
{
    public function settings()
    {
        $settings = DB::table('testbaik')->first();
        foreach ($settings as $key => $x) {
            if ($key != "baikTable_Names" &&
                $key != "id" &&
                $key != "Image_URL" &&
                $key != "Manufacturer" &&
                $key != "Model" &&
                $key != "Year" &&
                $key != "Bike_ID" &&
                $key != "Category_1" &&
                $key != "Category_2" &&
                $key != "MSRP" &&
                $key != "MSRP_currency" &&
                $key != "Description" &&
                $key != "Weight" &&
                $key != "Wheels_size" &&
                $key != "Shipping" &&
                $key != "Shifting" &&
                $key != "Spokes") {

                Detail::query()->updateOrCreate([
                    'key' => $key
                ]);
            }
        }
    }
    public function showDetail()
    {
        Detail::query()->WhereBetween('id',[9,26])
            ->where('id','!=',13)
            ->where('id','!=',23)
            ->where('id','!=',24)
            ->update(['is_show' => 1]);
    }
    public function request()
    {
        Bike::where('id', '>=', 1)->update([
            'send_request' => 0
        ]);
        Bike::where('id', '>=', 1)->update([
            'request' => 0
        ]);
    }

    public function components()
    {
        $components = [
            'Campagnolo Super Record EPS',
            'Campagnolo Super Record',
            'Campagnolo Record EPS',
            'Campagnolo Record',
            'Campagnolo Ekar',
            'Campagnolo Chorus EPS',
            'Campagnolo Chorus',
            'Campagnolo Athena EPS',
            'Campagnolo Athena',
            'Other Campagnolo',
            'Shimano Dura Ace Di2',
            'Shimano Dura Ace',
            'Shimano Ultegra',
            'Shimano Ultegra Di2',
            'Shimano GRX',
            'Shimano GRX Di2',
            'Shimano 105',
            'Shimano Tiagra',
            'Shimano Sora',
            'Shimano Claris',
            'Other Shimano',
            'SRAM Red eTap AXS',
            'SRAM Force eTap AXS',
            'SRAM Red eTap',
            'SRAM Red',
            'SRAM Force',
            'SRAM Rival',
            'SRAM Apex',
            'Other SRAM',
        ];

        foreach ($components as $component) {
            Component::create([
                'name' => $component
            ]);
        }
    }

    public function index()
    {
        $data = DB::table('testbaik')->limit(100)
            ->get();

        foreach ($data as $item) {
            $brand = Brand::query()->updateOrCreate([
                'name' => $item->Manufacturer,
            ]);
            $model = BrandModel::query()->updateOrCreate([
                'brand_id' => $brand->id,
                'name' => $item->Model,
            ]);
            $slug = DataService::getSlug($item->Bike_ID);
            $bike = Bike::query()->create([
                'name' => $item->Bike_ID,
                'slug' => $slug,
                'description' => ['en' => $item->Description],
                'year' => $item->Year ? $item->Year : '2020',
                'weight' => $item->Weight ? (double)$item->Weight : null,
                'wheels_size' => $item->Wheels_size ? (double)$item->Wheels_size : null,
                'msrp' => $item->MSRP ? (double)$item->MSRP : null,
                'price' => $item->MSRP ? (double)$item->MSRP : null,
                'msrp_currency' => 'EUR',
                'brand_id' => $brand->id,
                'brand_model_id' => $model->id,
                'image_path' => $item->Image_URL,
                'parent_id' => 0,
                'country_id' => 1,
                'status' => 'active',
                'user_id' => 1,
            ]);


            if ($item->Category_1) {
                $cat1 = Category::query()->updateOrCreate([
                    'name' => $item->Category_1,
                    'status' => 1
                ]);

                BikeCategory::query()->create([
                    'bike_id' => $bike->id,
                    'category_id' => $cat1->id,
                ]);
            }
            if ($item->Category_2) {
                $cat2 = Category::query()->updateOrCreate([
                    'name' => $item->Category_2,
                    'status' => 1
                ]);

                BikeCategory::query()->create([
                    'bike_id' => $bike->id,
                    'category_id' => $cat2->id,
                ]);
            }
            $details = Detail::all();
            foreach ($details as $detail) {
                if (json_decode(json_encode($item), 2)[$detail->key]) {
                    BikeSetting::query()->create([
                        'bike_id' => $bike->id,
                        'detail_id' => $detail->id,
                        'value' => json_decode(json_encode($item), 2)[$detail->key]
                    ]);
                }

            }
        }

    }
}
