@extends('layouts.app')

@section('PageCss')
    <link rel="stylesheet" href="/css/crop.css">
    <link href="{{mix('/css/profile.css')}}" rel="stylesheet">
@endsection

@section('content')
    @include('flash::message')

    <section class="profile-page">
        @include('profile.menu')
        {{--profile content--}}
        <div class="profile-container">
            <div class="profile-content">
                <div class="d-flex align-items-center mw-720">
                    <h1 class="profile-title">{{__('Published bicycles')}}</h1>
                    <a href="{{ route('sell') }}" class="btn btn_green ml-auto">
                        {{__('Add bike')}}
                    </a>
                </div>
                @if(count($bikes) <= 0)
                    <h2>{{__('There is no published bicycle yet')}}</h2>
                @endif
                <div class="shop-item-container">
                    @foreach($bikes as $bike)
                        <div class="shop-item shop-item-publish @if($bike->status != 'active') in show @endif"
                             id="collapse{{ $bike->id }}">
                            <a href="{{ route('shop.bike', $bike->slug) }}"
                               class="shop-item-img-block">
                                <img
                                    src="{{ $bike->image('side') ? $bike->image('side') : $bike->image_path ?? '/img/heco-1.png' }}"
                                    alt="{{__('Diverge E5 Base')}}" width="352" height="222"
                                    loading="lazy">

                                @if($bike->is_sold)
                                    <span class="drag-tags">{{__('Sold')}}
                                        <b class="drag-tooltip">{{\Carbon\Carbon::parse( $bike->booking->created_at)->format('Y-m-d')}}</b>
                                    </span>
                                @endif
                            </a>

                            @forelse($countes as $count)
                                @if(in_array($bike->id, $count))
                                    <a href="{{ route('notifications') }}">
                                        <div class="published-bike">
                                            <img src="/img/published-icon.svg" alt="">
                                            <span id="message_number">{{ $count['count'] }}</span>
                                        </div>
                                    </a>
                                @endif
                            @empty

                            @endforelse

                            <div class="shop-item-info-block">
                                <a href="{{ route('shop.bike', $bike->slug) }}"
                                   style="text-decoration: none; color: black">
                                    <div class="shop-item-title">
                                        <h2 title="{{__('Diverge E5 Base')}}">{{ $bike->brand->name ?? '' }}
                                            , {{ $bike->name }} </h2>
                                    </div>

                                    <table>
                                        <tr>
                                            <td>{{__('Year')}}</td>
                                            <td>{{ $bike->year }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('Size')}}</td>
                                            <td>{{ $bike->frame_size }}</td>
                                        </tr>
                                    </table>
                                </a>

                                <div class="publish-edit">
                                    <span><b>{{ $bike->format_price }} {{ $bike->msrp_currency }}</b></span>
                                    <div class="publish-edit-buttons">
                                        <input type="hidden" id="bike_val" value="{{ $bike->id }}">

                                        @if(($bike->booking && $bike->booking->status !== 'paid' && $bike->booking->status !== 'success') || !$bike->booking )
                                            <a href="{{route('sell.edit.information',$bike->id )}}"
                                               title="{{__('edit bike')}}" aria-label="{{__('edit bike')}}">
                                                <img src="/img/pencil-2.svg" alt="{{__('edit bike')}}" width="26"
                                                     eight="26"
                                                     loading="lazy">
                                            </a>


                                            <button
                                                @if($bike->is_sold == 1)
                                                    disabled
                                                @endif
                                                type="button"
                                                title="{{__('Active Inactive Bike')}}"
                                                class="btn publish-active-button eye_colaps"
                                                data-toggle="collapse"
                                                data-id="{{ $bike->id }}"
                                                aria-expanded="false"
                                                data-target="#collapse{{ $bike->id }}"
                                                aria-controls="collapse{{ $bike->id }}">
                                                <svg
                                                    id="Capa_1" enable-background="new 0 0 512.101 512.101"
                                                    height="512"
                                                    viewBox="0 0 512.101 512.101" width="512"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path
                                                            d="m436.862 75.238c-100.3-100.301-261.29-100.335-361.624 0-100.301 100.3-100.335 261.29 0 361.624 100.3 100.301 261.29 100.335 361.624 0 100.301-100.299 100.335-261.29 0-361.624zm-195.812 60.812c0-8.284 6.716-15 15-15s15 6.716 15 15v80c0 8.284-6.716 15-15 15s-15-6.716-15-15zm15 231c-61.206 0-111-49.794-111-111 0-32.026 13.837-62.493 37.965-83.589 6.237-5.453 15.713-4.818 21.166 1.418s4.818 15.713-1.418 21.166c-17.611 15.399-27.712 37.635-27.712 61.005 0 44.664 36.336 81 81 81s81-36.336 81-81c0-23.142-9.936-45.232-27.26-60.607-6.196-5.499-6.761-14.979-1.263-21.176 5.499-6.197 14.979-6.761 21.176-1.263 23.735 21.064 37.347 51.333 37.347 83.045-.001 61.207-49.795 111.001-111.001 111.001z"/>
                                                    </g>
                                                </svg>
                                            </button>

                                            <form action="{{ route('publish-destroy', $bike->id ) }}" method="POST"
                                                  style="display: none" onsubmit="return confirm('Are You Sure?')">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" onclick="$(this).prev().submit()" title="{{__('remove bike')}}"
                                               aria-label="{{__('remove bike')}}">
                                                <img src="/img/remove.svg" alt="remove bike" width="26" height="26"
                                                     loading="lazy">
                                            </a>
                                        @else
                                            <p>
                                                {{ \Carbon\Carbon::parse($bike->booking->updated_at)->format('d.m.Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach


                </div>
            </div>
        </div>

        {{--end profile content--}}
    </section>

    {{--        Edit price--}}
    <div class="hystmodal login-modal d-none" id="edit-price" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">Close</button>

                <h2 class="font-light text-center modal-title">{{__('Edit  Bike Price')}}</h2>

                <form method="POST" action="" id="edit_form">
                    @csrf
                    <div class="form-scroll">
                        <div class="form-group">
                            <input type="number"
                                   name="price"
                                   placeholder="{{__('Please enter the new price')}}"
                                   class="form-control login_email"
                                   aria-label="price"
                                   min="0"
                            >
                            <span class="invalid-feedback" role="alert"></span>
                            <input type="hidden" id="val_bike" name="bike_id" value="">
                            <span style="color: red" class="error_message"></span>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" id="edit_button"
                                class="btn btn_green">{{__('Edit')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/crop.js"></script>
    <script>
        function edit(id) {
            console.log(id);
            $('#val_bike').val(id);
        };

        $('#edit_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route('edit-bike')}}',
                type: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    window.location.replace("/published-bicycles");
                },
                error: (data) => {
                    let message = data.responseJSON.errors.price[0];
                    $('.error_message').empty();
                    $('.error_message').html(message);
                },
            });
        });


        $(document).ready(function () {
            $('.eye_colaps').on('click', function (e) {
                e.preventDefault();
                // let bike_id = $('#bike_val').val();
                console.log($(this).data('id'));
                $.ajax({
                    url: '{{route('eye-colaps')}}',
                    type: "POST",
                    data: {
                        id: $(this).data('id')
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        // window.location.replace("/personal-information");
                    },
                    error: (data) => {
                        $('.invalid-feedback').empty();
                        $.each(data.responseJSON.errors, (index, value) => {
                            $('.login_' + index).parent().find('.invalid-feedback').html(value).css('color', 'red');
                        });
                    },
                });
            });
        });


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
