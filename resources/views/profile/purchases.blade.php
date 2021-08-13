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
                <h1 class="profile-title">{{__('My purchases')}}</h1>

                @if(count($bookings) <= 0)
                    <h2 class="mt-5">
                        {{__('There is no bike in this list')}}
                    </h2>
                @endif
                <div class="shop-item-container">
                    @foreach($bookings as $booking)
                        <div class="shop-item">
                            <a href="{{ route('shop.bike', $booking->bike->slug) }}" class="shop-item-img-block">
                                <img src="{{ $booking->bike->image('side') ? $booking->bike->image('side') : $booking->bike->image_path ?? '/img/heco-1.png' }}"
                                     alt="{{__('Diverge E5 Base')}}" width="352" height="222"
                                     loading="lazy">
                            </a>
                            <div class="shop-item-info-block">
                                <a href="{{ route('shop.bike', $booking->bike->slug) }}"
                                   style="text-decoration: none; color: black">
                                    <div class="shop-item-title">
                                        <h2 title="{{__('Diverge E5 Base')}}">{{ $booking->bike->name }}</h2>
                                    </div>

                                    <table>
                                        <tr>
                                            <td>{{__('Specialized')}}</td>
                                            <td>
                                                @foreach($booking->bike->category as $category)
                                                    {{ $category->name }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Size')}}</td>
                                            <td>{{ $booking->bike->frame_size }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('I bought')}}</td>
                                            <td class="text-green"><b>{{ $booking->format_price }}</b></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Date')}}</td>
                                            <td>{{ $booking->created_at }}</td>
                                        </tr>
                                    </table>
                                </a>

                            </div>
                        </div>

                    @endforeach
                </div>


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
