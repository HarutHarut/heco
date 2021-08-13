@extends('layouts.app')

@section('PageCss')
    <link rel="stylesheet" href="/css/crop.css">
    <link href="{{mix('/css/profile.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="profile-page">

        @include('profile.menu')

        {{--profile content--}}
        <div class="profile-container">
            <div class="profile-content">
                <h1 class="profile-title">{{__('Favorites')}}</h1>

                @if(count($bikes) <= 0)
                    <h2 class="mt-5">{{__('There is no bike in this list')}}</h2>
                @endif

                <div class="shop-item-container">
                    @foreach($bikes as $bike)
                        <div class="shop-item">

                            <a href="{{ route('shop.bike', $bike->slug) }}"
                               class="shop-item-img-block">
                                <img src="{{ $bike->image('side') ? $bike->image('side') : $bike->image_path ?? '/img/heco-3.jpg' }}" alt="{{__('Diverge E5 Base')}}" width="352" height="222"
                                     loading="lazy">
                                @if($bike->check_time && !$bike->is_sold)
                                    <span class="bike-new"> {{__('Availabe From'). ' '.$bike->check_time}}</span>
                                @endif
                                @if($bike->IsNew && !$bike->check_time)
                                    <span class="bike-new"> {{__('New')}}</span>
                                @endif
                                @if($bike->is_sold)
                                    <span class="bike-new"> {{__('Sold')}}</span>
                                @endif
                                <button type="button" class="delete-fav" aria-label="delete Favorites"
                                        onclick="event.preventDefault(); document.getElementById('delete_favorite{{$bike->id}}').submit();"
                                ></button>
                            </a>

                            <div class="shop-item-info-block">
                                <a href="{{ route('shop.bike', $bike->slug) }}" style="text-decoration: none; color: black">
                                    <div class="shop-item-title">
                                        <h2 title="{{ $bike->name }}">{{ $bike->name }}</h2>
                                        <div class="form-group checkbox-choose ml-auto" title="{{__('compare')}}">
                                            <input onclick="compare( {{$bike->id}} )" type="checkbox"
                                                   id="choose{{$bike->id}}"
                                                   @if(\Illuminate\Support\Facades\Session::get('bike_ids'))
                                                   {{ array_key_exists( $bike->id, \Illuminate\Support\Facades\Session::get('bike_ids') ) ? 'checked' : '' }}
                                                   @endif
                                                   class="form-check-input">
                                            <label for="choose{{$bike->id}}" class="form-check-label">
                                        <span>
                                            <img src="/img/scale.svg" alt="compare" width="21" height="20"
                                                 loading="lazy">
                                        </span>
                                            </label>
                                        </div>
                                    </div>

                                    <table>
                                        <tr>
                                            <td>{{__('Specialized')}}</td>
                                            <td>{{ $bike->year }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Size')}}</td>
                                            <td>{{ $bike->frame_size }}</td>
                                        </tr>
                                    </table>
                                </a>
                                <div class="shop-item-price-block">
                                    <div class="shop-item-price">
                                        <p><span>{{ $bike->format_price }}</span> {{ $bike->msrp_currency }}</p>
                                    </div>
                                    @if(!$bike->check_time && !$bike->is_sold)
                                        <a href="{{ route('shop.bike', $bike->slug) }}"
                                           class="btn btn_green">{{__('Buy Now')}}</a>
                                    @else
                                        <a href="{{ route('shop.bike', $bike->slug) }}" class="btn btn_green btn_green_see">{{ __('See details') }}</a>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <form id="delete_favorite{{$bike->id}}" action="{{ route('favorite-destroy', $bike->id ) }}"
                              method="post" style="display: none;">
                            @csrf
                            @method('delete')
                        </form>

                    @endforeach



                </div>
                <hr>
                <h1 class="profile-title">{{__('Saved Filter')}}</h1>

                @if(!auth()->user()->filter)
                    <h2 class="mt-5">{{__('There is no filter saved yet')}}</h2>
                @else
                    <p><b>{{__('Min Price')}}:</b> {{auth()->user()->filter->filter['min_price']}}</p>
                    <p><b>{{__('Max Price')}}:</b>{{auth()->user()->filter->filter['max_price']}}</p>
                    <p><b>{{__('Year')}}:</b>@foreach(auth()->user()->filter->filter['year'] as $year) {{$year}}, @endforeach</p>
                    <p><b>{{__('Brand')}}:</b>@foreach(auth()->user()->filter->filter['brand_ids'] as $id) {{\App\Models\Brand::find($id)->name}}, @endforeach</p>
                    <p><b>{{__('Model')}}:</b>@foreach(auth()->user()->filter->filter['model_ids'] as $id) {{App\Models\BrandModel::find($id)->name}}, @endforeach</p>

                    <form action="{{route('filter.delete')}}" method="POST">
                        @csrf
                        <button class="btn btn_green">{{__('Delete Filter')}}</button>
                    </form>
                @endif
            </div>
        </div>
        {{--end profile content--}}
    </section>
@endsection

@section('scripts')
    <script src="/js/crop.js"></script>
    <script>
        // crop
        function getName(str) {
            if (str.lastIndexOf('\\')) {
                var i = str.lastIndexOf('\\') + 1;
            } else {
                var i = str.lastIndexOf('/') + 1;
            }
            var filename = str.slice(i);
            var uploaded = document.getElementById("fileformlabel");
            uploaded.innerHTML = filename;
        }

        $uploadCrop = $('#upload-img').croppie({
            enableExif: true,
            viewport: {
                width: 100,
                height: 100,
                type: 'circle'
            },
            boundary: {
                width: 150,
                height: 150
            }
        });
        $('#upload').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    $('.upload-result').attr('disabled', false);
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('.upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {
                $.ajax({
                    {{--url: "{{route('moderator-image', $moderator->id)}}",--}}
                    method: "POST",
                    data: {"image": resp},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        html = '<img src="' + resp + '" />';
                        $("#user-img").html(html);
                    }
                });
            });
        });

    </script>
@endsection
