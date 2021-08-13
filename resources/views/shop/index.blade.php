@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/shop.css')}}" rel="stylesheet">
@endsection

@section('content')
    @include('flash::message')
    <shop-component
        :brands="{{ $brands }}"
        :locale="'{{ app()->getLocale() }}'"
        :selected_brands="{{ $selectedBrands }}"
        :selected_models="{{ $selectedModels }}"
        :brand_ids="{{ json_encode($brand_ids) }}"
        :model_ids="{{ json_encode($model_ids) }}"
        :years="{{ json_encode($years) }}"
        :components="{{ json_encode($component) }}"
        :categories="{{ json_encode($categories) }}"
        :frame_materials="{{ json_encode($frame_materials) }}"
        :brake_types="{{ json_encode($brake_types) }}"
        :shifters="{{ json_encode($shifters) }}"
{{--        :year="{{ json_encode($year) }}"--}}
        :sizes="{{ json_encode($sizes) }}"
        :json_data="{{ json_encode($jsonData) }}"
        :compare_url="'{{route('compare')}}'"
        :compare_ids="{{ json_encode(Session::get('bike_ids')) }}"
        :filter_url="'{{ route('filter.save') }}'"
        :colors="{{ json_encode($color) }}"
        :filter_save="'{{ $filterSave }}'"
        :email_verified="'{{ $emailVerified }}'"
        @if(Auth::check())
        :auth="true"
        @else
        :auth="false"
        @endif
    />
@endsection

@section('scripts')
    <script>
        /*window.trans = <?php
        // copy all translations from /resources/lang/CURRENT_LOCALE/!* to global JS variable
        $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
        $trans = [];
        foreach ($lang_files as $f) {
            $filename = pathinfo($f)['filename'];
            if (pathinfo($f)['filename'] == '__shop__') {
                $trans[$filename] = trans($filename);
            }
        }

        echo json_encode($trans);
        ?>;*/

        // profile menu mobile open
        $(document).ready(function () {
            $(".open-filter").click(function () {
                $("body").addClass("opened-filter");
            });
            $(".close-filter").click(function () {
                $("body").removeClass("opened-filter");
            });


            $(document).click(function (event) {
                if (!$(event.target).is(".open-filter, .shop-filter *")) {
                    $("body").removeClass("opened-filter");
                }
            });
        })
    </script>
@endsection
