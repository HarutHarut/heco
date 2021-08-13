@extends('layouts.app')

@section('PageCss')
    <link rel="stylesheet" href="/css/crop.css">
    <link rel="stylesheet" href="/css/intlTelInput.min.css">
    <link href="{{mix('/css/profile.css')}}" rel="stylesheet">

{{--    <style>--}}
{{--        body, html{--}}
{{--            /*height: 100vh*/--}}
{{--            height: calc(var(--vh, 1vh) * 100);--}}
{{--            overflow: hidden;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('content')
    @include('flash::message')
    <section class="profile-page">

        @include('profile.menu')

        {{--profile content--}}
        <div class="profile-container">
            <div class="profile-content">
                <form action="{{ route('personal-information.update', auth()->user('id')) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')
                    <div class="col-50">
                        <h2 class="profile-title text-center">{{__('Personal information')}}</h2>

                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('First Name')}}"
                                name="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{old('first_name', $user->first_name)}}"
                            >
                            @error('first_name')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('Last Name')}}"
                                name="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                value="{{old('last_name', $user->last_name)}}"
                            >
                            @error('last_name')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="email"
                                placeholder="{{__('E-mail')}}"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                aria-label="{{__('E-mail')}}"
                                value="{{$user->email}}"
                            >
                            @error('email')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="tel" placeholder="{{__('Phone')}}" name="phone"
                                class="tel-input form-control @error('phone') is-invalid @enderror"
                                aria-label="{{__('Phone')}}"
                                value="{{$user->phone}}">
                            @error('phone')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>
                        <h2 class="profile-title text-center">{{__('Birth Date')}}</h2>
                        <div class="form-group-column-3">
                            <div class="form-group">
                                <select name="day" class="form-control minimal">
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{$i}}" @if(old('day', $user->birth_date ? (int)$user->birth_date->format('d') : '') == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="month" class="form-control minimal">
                                    @foreach(config('enums.months') as $key => $value)
                                        <option value="{{$key}}" @if(old('month', $user->birth_date ? (int)$user->birth_date->format('m') : '') == $key) selected @endif>{{__($value)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="year" class="form-control minimal">
                                    @for($i = date('Y') - 100; $i <= date('Y'); $i++)
                                        <option value="{{$i}}" @if(old('year', $user->birth_date ? (int)$user->birth_date->format('Y') : '') == $i) selected @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <br>
                        <h2 class="profile-title text-center">{{__('Shipping address')}}</h2>

                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('Doutchland')}}"
                                name="country"
                                class="form-control @error('country') is-invalid @enderror"
                                aria-label="{{__('Country')}}"
                                value="{{__('Doutchland')}}"
                                readonly
                            >
                            @error('country')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <select name="state" class="form-control minimal">
                                <option value="">{{__('Select State')}}</option>
                                @foreach(config('enums.states') as $state)
                                    <option value="{{$state}}" @if(old('state', $user->state) == $state) selected @endif>{{__($state)}}</option>
                                @endforeach
                            </select>
                            @error('state')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('City')}}"
                                id="search-address"
                                name="city"
                                class="form-control @error('city') is-invalid @enderror"
                                aria-label="{{__('City')}}"
                                value="{{old('city', $user->city)}}"
                            >
                            @error('city')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('Street')}}"
                                name="street"
                                class="form-control @error('street') is-invalid @enderror"
                                aria-label="{{__('Street')}}"
                                value="{{ old('street', $user->street)}}"
                            >
                            @error('street')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('House number')}}"
                                name="house_number"
                                class="form-control @error('house_number') is-invalid @enderror"
                                aria-label="{{__('House number')}}"
                                value="{{ old('house_number', $user->house_number)}}"
                                min="0"
                            >
                            @error('house_number')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                placeholder="{{__('ZIP')}}"
                                name="zip"
                                class="form-control @error('zip') is-invalid @enderror"
                                aria-label="{{__('ZIP')}}"
                                value="{{ old('zip', $user->zip)}}"
                            >
                            @error('zip')
                            <div style="color: red">{{ $message }}</div>
                            @enderror
                        </div>
                        <br>

                        <div class="col-100 text-right">
                            <button type="submit" class="btn btn_green mt-22">{{__('Save')}}</button>
                        </div>
                        <br>
                        <br>
                    </div>

                </form>
            </div>
        </div>
        {{--end profile content--}}
    </section>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&libraries=places"></script>
    <script src="/js/crop.js"></script>

    <script>

        $(document).ready(function() {
            $('.minimal').select2();
        });


        function initialize() {
            var ac = new google.maps.places.Autocomplete(document.getElementById('search-address'));
            ac.setComponentRestrictions(
                {'country': ['DE'], 'postalCode': []});
        }

        $(function() {
            initialize();
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
                    url: "{{route('profile-picture-update')}}",
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
