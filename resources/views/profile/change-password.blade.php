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
                <form action="{{ route('password-update') }}" method="POST" class="row">
                    @csrf
                    <div class="col-50">
                        <h2 class="profile-title">{{__('Change password')}}</h2>

                        <div class="form-group">
                            <input
                                type="password"
                                   placeholder="{{__('Old password')}}"
                                   name="old_password"
                                   class="form-control @error('old_password') is-invalid @enderror"
                                   aria-label="{{__('Old password')}}"
                            >
                            @error('old_password')
                            <label style="color: red">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="password"
                                placeholder="{{__('New password')}}"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                aria-label="{{__('New password')}}"
                            >
                            @error('password')
                            <label style="color: red">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input
                                type="password"
                                placeholder="{{__('Confirm password')}}"
                                name="password_confirmation"
                                class="form-control"
                                aria-label="{{__('Confirm password')}}"
                            >
                        </div>
                    </div>

                    <div class="col-100">
                        <button type="submit" class="btn btn_green mt-22">{{__('Save')}}</button>
                    </div>
                </form>
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
            }
            else {
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
