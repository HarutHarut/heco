@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <section class="sell-5-section d-flex flex-wrap">

        <div class="sell-5-left">
            <div class="sell-5-lef-container">
                <h1>{{ $bike->name }}</h1>

                <div id="drop--area">
                    <form action="{{ route('sell.images', ['bike_id' => $bike_id]) }}" method="POST" class="form"
                          id="form"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="side" id="file--input1"
                               class="file--input @error('side') is-invalid @enderror" accept="image/*"
                               onchange="handleFiles(this.files)"
                        >
                        <label for="file--input1" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload side View')}}
                        </label>
                        @error('side')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                        <input type="file" name="crank" id="file--input2"
                               class="file--input @error('crank') is-invalid @enderror" accept="image/*"
                               onchange="handleFiles(this.files)">
                        <label for="file--input2" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload crank view')}}
                        </label>
                        @error('crank')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                        <input type="file" name="top" id="file--input3"
                               class="file--input @error('top') is-invalid @enderror" accept="image/*"
                               onchange="handleFiles(this.files)">
                        <label for="file--input3" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload top cockpit view')}}
                        </label>
                        @error('top')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                        <input type="file" name="defects[]" id="file--input4" multiple
                               class="file--input @error('defects[]') is-invalid @enderror" accept="image/*"
                               onchange="handleFiles(this.files)">
                        <label for="file--input4" class="button">
                            <img src="/img/upload.svg" alt="" width="16" height="16">
                            {{__('Upload cosmetic defects')}}
                        </label>
                        @error('defects[]')
                        <span style="color: red" role="alert">{{ $message }}</span>
                        @enderror
                        <input type="hidden" id="type" name="type">
                        <div class="text-center">
                            <button type="submit" class="btn btn_green mt-22">{{__('Sell this bike')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="sell-5-right">
            <div class="sell-5-right-container">
                <div class="sell-5-right-block">
                    <h2 class="text-center">{{__('Please take 4 pictures of your bike')}}</h2>

                    <div class="pictures-bike-info-block">
                        <div class="pictures-bike-info">
                            <p>{{__('One from the side')}}</p>
                            <img src="/img/bike-side-1-3.jpg" alt="">
                        </div>
                        <div class="pictures-bike-info">
                            <p>{{__('One from the front')}}</p>
                            <img src="/img/bike-side-3.jpg" alt="">
                        </div>
                        <div class="pictures-bike-info">
                            <p>{{__('One from the cockpit view')}}</p>
                            <img src="/img/bike-side-2.jpg" alt="">
                        </div>
                    </div>

                    <h3>{{__('If there are cosmetic defects, please try to capture those in additional pictures')}}</h3>
                </div>

                <h4>{{__('Your pictures:')}}</h4>

                <div id="gallery">
                    @foreach($bike->images as $image)
                        <figure class="preview"><img class="img" src="{{'/storage/bikes/' . $image->imageable_id . '/thumb/210/' . $image->path}}">
                            <span class="mainSpan" data-id="{{$image->id}}" data-type="{{$image->type}}">
                                <span class="spanOne"></span><span class="spanTwo"></span>
                            </span>
                        </figure>
                    @endforeach
                </div>

                <div class="qr-code">
                    <div>
                        <img src="{{$bike->qr ?: '/img/qr.jpg'}}" alt="qr">
                    </div>
                    <p>{{__('Or take pictures with your')}}<br>
                        {{__('phone by scanning the QR code')}}
                    </p>
                </div>
            </div>
        </div>

    </section>

@endsection


@section('scripts')

    <script>
        const dropArea = document.getElementById('drop--area');

        function handleFiles(files) {
            return new Promise((resolve, reject) => {
                const Files = Array.from(files);
                const createFileId = (length) => {
                    let str = "";
                    for (; str.length < length; str += Math.random().toString(36).substr(2)) ;
                    return str.substr(0, length);
                }
                Files.forEach(file => {
                    file.id = createFileId((Math.round(file.lastModified * 100) / file.lastModified));
                    previewFile(file);
                });

                resolve(document.getElementById('gallery'));
            })
        }

        function previewFile(file) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                const img = document.createElement('img');
                const fig = document.createElement('figure');
                const spanOne = document.createElement('span');
                const spanTwo = document.createElement('span');
                const mainSpan = document.createElement('span');
                fig.classList.add('preview');
                img.classList.add('img');
                mainSpan.classList.add('mainSpan');
                spanOne.classList.add('spanOne');
                spanTwo.classList.add('spanTwo');
                mainSpan.onclick = function (e) {
                    this.parentElement.remove();
                }
                img.src = reader.result;
                [spanOne, spanTwo].forEach(item => {
                    mainSpan.appendChild(item);
                });
                [img, mainSpan,].forEach(item => {
                    fig.appendChild(item);
                });
                // document.getElementById('gallery').appendChild(fig);
            }
        }

        $('.file--input').change(function (){
            var type = $(this).attr('name');
            $('#type').val(type);
            var formData = new FormData(document.getElementById("form"));
            $.ajax({
                url: '{{route('mobile.images.upload', $bike->id)}}',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                }
            });
        });

        $(document).on('click', '.mainSpan', function (){
            var el = $(this);
            var image_id = el.data('id');
            var type = el.data('type');
            $.ajax({
                url: '{{route('mobile.images.destroy')}}',
                type: "POST",
                data: {
                    image_id: image_id,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    el.parent().remove();
                    $('[name="' + type + '"]').val('')
                }
            });

        })

        setInterval(function (){
            $.ajax({
                url: '{{route('mobile.images.get', $bike->id)}}',
                type: "GET",
                data: {},
                success: function (data) {
                    $('#gallery').html(data);
                }
            });
        }, 2000);

    </script>
@endsection
