@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/main.css')}}" rel="stylesheet">
@endsection

@section('content')

    <filter-component
        :brands="{{ json_encode($brands) }}"
        :models="{{ json_encode($models) }}"
        :years="{{ json_encode($years) }}"
        :url="'{{ route('shop.index') }}'"
    />

@endsection

@section('scripts')
<script>
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
