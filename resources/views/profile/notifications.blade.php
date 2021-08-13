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
                <h1 class="profile-title">{{__('Notifications')}}</h1>
                <div class="panel-group" id="accordion" role="tablist">
                    @if(!count($offers))
                        <h2 class="mt-5">
                            {{__('There is no notifications in this list')}}
                        </h2>
                    @endif
                    @foreach($offers as $item)
                        @if($item->recivient_id == auth()->id())
                            <div class="collapse-item">
                                <a class="collapse-head @if(!$collaps_recivient) collapsed @endif" role="button"
                                   data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{ $item->id }}" aria-expanded="@if($collaps_recivient) true  @else false @endif" aria-controls="collapse1">
                                    <img src="/img/price-tag.svg" alt="{{ $item->bike->name }}"
                                         width="27" height="27"
                                         loading="lazy">

                                    <span>{{ $item->bike->brand->name ?? $item->bike->brand_id }}, {{ $item->bike->name }}</span>

                                </a>
                                <div id="collapse{{ $item->id }}" class="collapse @if($collaps_recivient) show @endif" role="tabpanel">
                                    <div class="panel-body">
                                        <img
                                            src="{{ $item->bike->image('side') ? $item->bike->image('side') : $item->bike->image_path ?? '/img/heco-3.jpg' }}"
                                            alt="" width="126" height="80" loading="lazy"
                                            class="noty-bike">
                                        @if( $item->message )
                                            <div class="noty-buyer">
                                                <img src="{{ $item->sender->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                <p style="color: black">{{__('You have a new price offer for'). ' '. $item->message.' € .' }}
                                                </p>
                                            </div>
                                        @endif
                                        @if($item->status == -1)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                @if(isset($item->answer))
                                                    <p class="text-red">{{__('The price offer for'). ' '. $item->answer. ' € ' . __('was declined')}}</p>
                                                @else
                                                    <p class="text-red">{{__('The price offer for'). ' '. $item->message. ' € ' . __('was declined')}}</p>
                                                @endif

                                            </div>
                                        @endif
                                        @if($item->status == 2)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                <p class="text-green">{{__('The price offer for'). ' '. $item->message. ' € ' . __('was approved')}}</p>
                                            </div>
                                        @endif
                                        @if($item->answer && $item->status != -1 && $item->status != 2)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30"
                                                     loading="lazy">

                                                <p class="{{  $item->answer ? 'text-green' : 'text-red'}}">{{__('New price offer for')}}
                                                    {{ $item->answer .' € '.__('was sent')}}.</p>
                                            </div>
                                        @endif

                                        <form
                                            action="{{ route('shop.answer', ['id' => $item->id]) }}"
                                            method="POST"
                                            class="send-my-price">
                                            @csrf

                                            @if($item->status != -1 && $item->status != 2)
                                                @if(!$item->answer && $item->sender_id != Auth::id())
                                                    <div class="text-right mr-auto">
                                                        <a href="{{ route('dicline-approve', [ 'approve' => 0, 'bike_id' => $item->bike_id, 'message_id' => $item->id ]) }}"
                                                           class="btn btn_white">{{__('Dicline')}}</a>
                                                        <a href="{{ route('dicline-approve', [ 'approve' => 1, 'bike_id' => $item->bike_id, 'message_id' => $item->id ]) }}"
                                                           class="btn btn_green">{{__('Approve')}}</a>
                                                    </div>

                                                    @if(!$item->answer)
                                                        <input type="number"
                                                               name="answer"
                                                               min="0"
                                                               class="form-control"
                                                               placeholder="{{__('Write new price')}}">
                                                        <button type="submit"
                                                                class="btn btn_green">{{__('Send')}}</button>
                                                    @endif
                                                @endif
                                            @endif

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="collapse-item">
                                <a class="collapse-head @if(!$collaps_sender) collapsed @endif" role="button"
                                   data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse{{ $item->id }}" aria-expanded="@if($collaps_sender) true  @else false  @endif" aria-controls="collapse2">
                                    <img src="/img/price-tag.svg" alt="{{ $item->bike->name ?? '' }}"
                                         width="27" height="27">

                                    <span>{{ $item->bike->brand->name ?? $item->bike->brand_id }}, {{ $item->bike->name}}</span>

                                </a>
                                <div id="collapse{{ $item->id }}" class="collapse  @if($collaps_sender) show @endif" role="tabpanel">
                                    <div class="panel-body">
                                        <img
                                            src="{{ $item->bike->image('side') ? $item->bike->image('side') : $item->bike->image_path ?? '/img/heco-3.jpg' }}"
                                            alt="" width="126" height="80" loading="lazy"
                                            class="noty-bike">
                                        @if($item->message)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->sender->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                <p style="color: black">{{__('Counter offer for ') . ' ' . $item->message .' € '.__('was sent')}}</p>
                                            </div>
                                        @endif
                                        @if($item->status == -1)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                @if(isset($item->answer))
                                                    <p class="text-red">{{__('The price offer for'). ' '. $item->answer. ' € ' . __('was declined')}}</p>
                                                @else
                                                    <p class="text-red">{{__('The price offer for') . ' ' . $item->message .' € '.__('was declined')}}</p>
                                                @endif
                                            </div>
                                        @endif
                                        @if($item->status == 2)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                <p class="text-green">{{__('The price offer for')}} {{ $item->message .' € '.__('was approved')}}</p>
                                            </div>
                                        @endif

                                        @if($item->answer && $item->status != 2 && $item->status != -1)
                                            <div class="noty-buyer">
                                                <img src="{{ $item->recivient->image_path ?: '/img/profile-user.svg'}}"
                                                     alt=""
                                                     width="30" height="30" loading="lazy">
                                                <p class="text-green">{{__('You have a new price offer for ') . ' ' . $item->answer .' € '}}</p>
                                            </div>
                                        @endif
                                        @if($item->status == 2 && !$item->answer || $item->answer && $item->status != -1)
                                            @if($item->status != 2)
                                                <a href="{{ route('dicline-approve', [ 'approve' => 0, 'bike_id' => $item->bike_id, 'message_id' => $item->id ]) }}"
                                                   class="btn btn_white">{{__('Dicline')}}</a>
                                            @endif
                                            <a href="{{ route('shop.bike', ['slug'=> $item->bike->slug, 'message_id' => $item->id] ) }}"
                                               class="btn btn_green noty-buy-btn">{{__('Buy Now')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
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
