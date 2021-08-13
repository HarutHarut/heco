@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
    <link href="/css/toastr.min.css" rel="stylesheet">
    <style>
        .sell-5-lef-container, .sell-5-left{
            margin: 0 auto;
            padding: 29px 10px;
        }
    </style>
@endsection

@section('content')

    <section class="sell-5-section d-flex flex-wrap">

        <div class="sell-5-left">
            <div class="sell-5-lef-container">
                <div id="drop--area">
                    <form id="upload-form" enctype="multipart/form-data">
                        @csrf
                        <div id="side-div">
                        <input type="file" name="side" id="file--input1"
                               class="file--input @error('side') is-invalid @enderror" accept="image/*">
                        <label for="file--input1" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload side View')}}
                        </label>
                        </div>
                        <div id="crank-div">
                        <input type="file" name="crank" id="file--input2"
                               class="file--input @error('crank') is-invalid @enderror" accept="image/*">
                        <label for="file--input2" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload crank view')}}
                        </label>
                        </div>
                        <div id="top-div">
                        <input type="file" name="top" id="file--input3"
                               class="file--input @error('top') is-invalid @enderror" accept="image/*">
                        <label for="file--input3" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload top cockpit view')}}
                        </label>
                        </div>
                        <div id="defects-div">
                        <input type="file" name="defects[]" id="file--input4" multiple
                               class="file--input @error('defects[]') is-invalid @enderror" accept="image/*">
                        <label for="file--input4" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload cosmetic defects')}}
                        </label>
                        </div>
                        <input type="hidden" id="type" name="type">
                    </form>
                    </div>
                </div>
                </div>

    </section>

@endsection

@section('scripts')
    <script src="/js/toastr.min.js" type="text/javascript"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000"
        };

        $('.file--input').change(function (){
            var type = $(this).attr('name');
            $('#type').val(type);
            var formData = new FormData(document.getElementById("upload-form"));
            $.ajax({
                url: '{{route('mobile.images.upload', $bike->id)}}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    toastr.success('Image Uploaded');
                }
            });
        });

    </script>
@endsection



