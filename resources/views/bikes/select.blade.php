@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="sell-3">
        <picture class="sell-3-bg">
            <source srcset="/img/sell-4-bg.webp" type="image/webp">
            <source srcset="/img/sell-4-bg.jpg" type="image/jpg">
            <img src="/img/sell-4-bg.jpg" alt="" width="1920" height="1237" loading="lazy">
        </picture>

        <h1>{{__('We have found the following models')}}</h1>

        <div class="sell-3-container">

            @foreach($bikes as $bike)
                <div class="sell-3-item">
                    <picture>
                        <img src="{{ $bike->side_image ?? $bike->image_path ?? '/img/sellbike-1.jpg' }}" alt="" width="260" height="249" loading="lazy">
                    </picture>
                    <div class="sell-3-item-info">

                        <h3>{{ $bike->name }}</h3>
                        <p>{{ $bike->year }}</p>
                        <form action="{{ route('sell.select.store', $bike->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn_green">{{__('That´s my bike')}}</button>
                        </form>

                    </div>
                </div>
            @endforeach

        </div>

    </section>

@endsection
@section('scripts')
    <script>
        var page = 1;

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                infinteLoadMore(page);
            }
        });

        function infinteLoadMore(page)
        {
            console.log(page);
            $.ajax({
                url: '{{route('sell.select')}}',
                type: "get",
                data:{
                    page: page,
                    search: '{{request()->get('search')}}',
                    search_year: '{{request()->get('search_year')}}',
                    year: '{{request()->get('year')}}',
                    brand: '{{request()->get('brand')}}',
                    model: '{{request()->get('model')}}',
                }
            }).done(function (data) {
                $(".sell-3-container").append(data);
            })
        }
    </script>
@endsection


