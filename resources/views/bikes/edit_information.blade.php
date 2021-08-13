@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')

    <div class="sell-1-container justify-content-center">
        <h1>{{ $bike->brand->name }}, {{ $bike->name }}, {{ $bike->year }}</h1>
    </div>
    <form action="{{ route('sell.edit_bike', $bike->id) }}" method="POST" class="edit-bike-form">
        @csrf
        @method('POST')
        <section class="sell-1">
            <div class="sell-1-container sell-edit-container">
                <div class="sell-edit-container-left">
                    <div class="sell-1-form">
                        <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal"><img src="/img/iconsQ2.png" alt="" width="17"
                                                                                height="17"></a>
                        </span>
                            <select name="frame_size" class="minimal @error('frame_size') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Frame size')}}</option>
                                @for($i = 48 ; $i<=62 ;$i++)
                                    <option
                                        {{ old('frame_size') ? old('frame_size') == $i ? 'selected' : '' : $bike->frame_size == $i ? 'selected':''}} value="{{$i}}">
                                        {{$i}}
                                    </option>
                                @endfor
                            </select>
                            @error('frame_size')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                         <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal2"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                            <select name="condition" class="minimal @error('condition') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Condition')}}</option>
                                @foreach(config('enums.CONDITION') as $key => $condition)
                                    <option
                                        {{ old('condition')? old('condition') == $key ? 'selected' : '' : $bike->condition == $key ?'selected' : '' }}
                                        value="{{$key}}"
                                    >
                                        {{__($condition)}}
                                    </option>
                                @endforeach

                            </select>
                            @error('condition')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="color-wrapper">
                                <input type="text" name="" placeholder="{{__('Color')}}" id="pickcolor"
                                       value="" class="form-control call-picker" aria-label="{{__('Color')}}" readonly>
                                <input id="hidden_color" type="hidden" name="color" value="{{$bike->color}}">
                                <div style="background-color: {{$bike->color }}" class="color-holder call-picker"></div>
                                <div class="color-picker" id="color-picker" style="display: none"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input min="0" type="number" placeholder="{{__('Price €')}}" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   aria-label="{{__('Price')}}"
                                   value="{{ old('price') ?? $bike->price }}"
                            >
                            @error('price')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="switch">
                                <input
                                    {{ old('bargain') !== '0' && old('bargain') !== '1'  ? $bike->bargain == 0 ? 'checked' : '' : old('bargain') === '0' ? 'checked' :''  }} type="radio"
                                    name="bargain" id="yes"
                                    value="0" checked>
                                <label for="yes">{{__('Fixed')}}</label>
                                <input
                                    {{ old('bargain') !== '0' && old('bargain') !== '1'  ? $bike->bargain == 1 ? 'checked' : '' : old('bargain') === '1' ? 'checked' :'' }} type="radio"
                                    name="bargain" id="no"
                                    value="1">
                                <label for="no">{{__('Negotible')}}</label>
                                <span class="switchFilter"></span>
                            </div>

                        </div>
                        <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal3"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                            <select name="milage" class="minimal @error('milage') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Milage')}}</option>
                                @foreach(config('enums.MILAGE') as $key => $milage)
                                    <option
                                        value="{{$key}}" {{ old('milage')? old('milage') == $key ? 'selected' : '' : $bike->milage == $key ?'selected' : '' }} >
                                        {{__($milage)}}
                                    </option>
                                @endforeach
                            </select>
                            @error('milage')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="form-group">
                        <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal4"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                            <select name="last_service" class="minimal @error('last_service') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Last Service')}}</option>
                                @foreach(config('enums.SERVICE') as $key => $service)
                                    <option
                                        {{ old('last_service') ? old('last_service') == $key ? 'selected' : '' : $bike->last_service == $key ?'selected' : '' }}
                                        value="{{$key}}"
                                    >
                                        {{__($service)}}
                                    </option>
                                @endforeach
                            </select>
                            @error('last_service')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <select name="preowned" class="minimal @error('preowned') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Was this bike preowned')}}</option>

                                <option
                                    {{ old('preowned') !== '0' && old('preowned') !== '1'  ? $bike->preowned == 1 ? 'selected' : '' : old('preowned') === '1' ? 'selected' :'' }} value="1">{{__('Yes')}}</option>
                                <option
                                    {{ old('preowned') !== '0' && old('preowned') !== '1'  ? $bike->preowned == 0 ? 'selected' : '' : old('preowned') === '0' ? 'selected' :'' }} value="0">{{__('No')}}</option>
                            </select>
                            @error('preowned')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                          <span class="form-tooltip">
                            <a href="#" data-hystmodal="#frame-info-modal5"><img src="/img/iconsQ2.png" alt=""
                                                                                 width="17" height="17"></a>
                        </span>
                            <select name="shipping" class="minimal @error('shipping') is-invalid @enderror">
                                <option value="" selected disabled>{{__('Shipping')}}</option>
                                <option
                                    {{ old('shipping') !== '0' && old('shipping') !== '1'  ? $bike->shipping == 0 ? 'selected' : '' : old('shipping') === '0' ? 'selected' :'' }} value="0">{{__('Shipping Only')}}</option>
                                <option
                                    {{ old('shipping') !== '0' && old('shipping') !== '1'  ? $bike->shipping == 1 ? 'selected' : '' : old('shipping') === '1' ? 'selected' :'' }} value="1">{{__('Shipping or Pick-Up')}}</option>
                            </select>
                            @error('shipping')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input name="location"
                                   id="search-address"
                                   class="form-control @error('city') is-invalid @enderror"
                                   aria-label="{{__('Location')}}"
                                   value="{{ old('location') ?? $bike->city }}"
                            >
                            @error('location')
                            <span style="color: red" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="info"
                                   class="form-control"
                                   aria-label="{{__('Info about bike')}}"
                                   placeholder="{{__('Info about bike')}}"
                            >{{ old('info') ?? $bike->info }}</textarea>
                        </div>

                    </div>
                </div>
                <div class="sell-edit-container-right">
                    <div class="sell-1-components">
                        <h2>{{__('Components')}}<br>
                            <span>{{__('Click on a component to change it or to report it broken / exchanged')}}</span>
                        </h2>
                        <table>
                            @foreach($details as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex custom-radio-block">
                                            @php
                                                $detail_status = 0;
                                                if(isset($bike)){
                                                    $detail_id = 0;
                                                    if (in_array($item->id, $bike->bike_settings->pluck('detail_id')->toArray())){
                                                        $detail_id = $item->id;
                                                    }

                                                    if ($detail_id){
                                                          $detail_status = $bike->bike_settings()->where('detail_id', $detail_id)->first()->status;
                                                    }
                                                }

                                            @endphp

                                            <div class="radio-grey">
                                                <input type="radio" id="test53{{$item->id}}"
                                                       name="{{$item->id}}"
                                                       class="custom-radio"
                                                       @if(old($item->id) == 0) checked @endif
                                                       onclick="toggle({{$item->id}})"
                                                       value="0"
                                                >
                                                <label for="test53{{$item->id}}"></label>
                                            </div>

                                            <div class="radio-green">
                                                <input type="radio" id="test7{{$item->id}}"
                                                       name="{{$item->id}}"
                                                       class="custom-radio"
                                                       onclick="toggle({{$item->id}})"
                                                       value="1"
                                                    {{!is_null(old($item->id)) ? old($item->id) == 1 ? 'checked' : '' : $detail_status == 1 ? 'checked' :''}}
                                                >
                                                <label for="test7{{$item->id}}"></label>
                                            </div>

                                            <div class="radio-yellow">
                                                <input type="radio" id="test8{{$item->id}}"
                                                       onclick="details({{$item->id}})"
                                                       name="{{$item->id}}"
                                                       class="custom-radio detail_radio"
                                                       value="2"
                                                    {{!is_null(old($item->id)) ? old($item->id) == 2 ? 'checked' : '' : $detail_status == 2 ? 'checked' :''}}
                                                >

                                                <label for="test8{{$item->id}}"></label>
                                            </div>

                                            <div class="radio-red">
                                                <input type="radio" id="test9{{$item->id}}"
                                                       name="{{$item->id}}"
                                                       class="custom-radio"
                                                       onclick="toggle({{$item->id}})"
                                                       value="3"
                                                    {{!is_null(old($item->id)) ? old($item->id) == 3 ? 'checked' : '' : $detail_status == 3 ? 'checked' :''}}
                                                >
                                                <label for="test9{{$item->id}}"></label>
                                            </div>

                                        </div>
                                    </td>
                                    <td><span>{{$item->key ?? ''}}</span>
                                    </td>
                                    <td class="toggle">
                                        @php
                                            $value = '';
                                            if (isset($bike)){
                                                $detail = $bike->bike_settings()->where('detail_id', $item->id)->first();
                                                if ($detail){
                                                    if ($detail->status == \App\Models\Bike::STATUS_DETAIL_CHANGED){
                                                        $value = $detail->note;
                                                    }else{
                                                        $value = $detail->value;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <span id="span_{{ $item->id }}" class="span_{{ $item->id }}">{{ $value }}</span>
                                        <input name="details{{$item->id}}" id="details{{$item->id}}" type="text"
                                               value="{{old("details$item->id") ?? $value}}"
                                               style="display: none" class="form-control input_{{$item->id}}">
                                        @if(old($item->id) == 2 || $detail_status == 2)
                                            <script>
                                                document.querySelector('.span_' + '{{ $item->id }}').style.display = 'none';
                                                document.querySelector('.input_' + '{{ $item->id }}').style.display = 'block';
                                            </script>
                                        @endif

                                    </td>
                                </tr>

                            @endforeach
                        </table>

                        <div class="component-info">
                            <div><span class="circle circle-grey"></span> {{__('default parts')}}</div>
                            <div><span class="circle circle-green"></span> {{__('Replaced parts')}}</div>
                            <div><span class="circle circle-yellow"></span> {{__('Changed parts')}}</div>
                            <div><span class="circle circle-red"></span> {{__('Broken parts')}}</div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </form>

    <section class="sell-5-section d-flex flex-wrap sell-5-section-edit">
        <div class="sell-5-left">
            <div class="sell-5-lef-container">
                <div id="drop--area"></div>
                <form action="{{ route('sell.images', ['bike_id' => $bike->id]) }}" method="POST" class="form"
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
                </form>

            </div>
        </div>
        <div class="sell-5-right bg-white">
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
                        <figure class="preview"><img class="img"
                                                     src="{{'/storage/bikes/' . $image->imageable_id . '/thumb/210/' . $image->path}}">
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
        <div class="text-center w-100">
            <button type="submit" class="btn btn_green mt-22 edit-bike">{{__('Edit this bike')}}</button>
        </div>
    </section>


    <div class="hystmodal login-modal" id="frame-info-modal" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 1')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 1')}}
                </div>
                <table class="table">
                    <tr>
                        <td>{{__('Frame size')}}</td>
                        <td>{{__('Frame size in cm')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XXS')}}</td>
                        <td>{{__('48')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XS')}}</td>
                        <td>{{__('50')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('S')}}</td>
                        <td>{{__('52')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('M')}}</td>
                        <td>{{__('54')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('L')}}</td>
                        <td>{{__('57')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XL')}}</td>
                        <td>{{__('59')}}</td>
                    </tr>
                    <tr>
                        <td>{{__('XXL')}}</td>
                        <td>{{__('62')}}</td>
                    </tr>
                </table>
                <p>{{__('Solltest du trotzdem nicht sicher sein, welche Rahmengröße dein Rad hat, schreib uns doch einfach eine Mail an')}}
                    <a href="mailto:info@buycycle.de">info@buycycle.de</a></p>
            </div>
        </div>
    </div>
    <div class="hystmodal login-modal" id="frame-info-modal2" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center"><b>{{__('The conditions on buycycle 2')}}</b></h2>
                <div>
                    <p>{{__('The conditions on buycycle text 2')}}</p>
                    <p>{{__('The conditions on buycycle text 2-2')}}</p>

                    <h3 class="mb-0"><b>{{__('Perfekt title')}}</b></h3>
                    <p>{{__('Perfekt text')}}</p>

                    <h3 class="mb-0"><b>{{__('Sehr Gut title')}}</b></h3>
                    <p>{{__('Sehr Gut text')}}</p>

                    <h3 class="mb-0"><b>{{__('Gut title')}}</b></h3>
                    <p>{{__('Gut text')}}</p>

                    <h3 class="mb-0"><b>{{__('OK title')}}</b></h3>
                    <p>{{__('OK text')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal login-modal" id="frame-info-modal3" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 3')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 3')}}
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal login-modal" id="frame-info-modal4" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 4')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 4')}}
                </div>
            </div>
        </div>
    </div>
    <div class="hystmodal login-modal" id="frame-info-modal5" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h3 class="font-light text-center"><b>{{__('The conditions on buycycle 5')}}</b></h3>
                <div>
                    {{__('The conditions on buycycle text 5')}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&libraries=places"></script>
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

        $('.file--input').change(function () {
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

        $(document).on('click', '.mainSpan', function () {
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

        setInterval(function () {
            $.ajax({
                url: '{{route('mobile.images.get', $bike->id)}}',
                type: "GET",
                data: {},
                success: function (data) {
                    $('#gallery').html(data);
                }
            });
        }, 2000);

        $(document).ready(function () {
            $('.minimal').select2();
        });

        function initialize() {
            var ac = new google.maps.places.Autocomplete(document.getElementById('search-address'));
            ac.setComponentRestrictions(
                {'country': ['DE'], 'postalCode': []});
        }

        $(function () {
            initialize();
        });

        function details(id) {
            let span_class = '.span_' + id;
            let input_details = '.input_' + id;
            $(`${span_class}`).hide();
            $(`${input_details}`).show();

        };

        function toggle(id) {
            let span_class = '.span_' + id;
            let input_details = '.input_' + id;
            if (input_details) {
                $(`${span_class}`).show();
                $(`${input_details}`).hide();
            }
        };

        $(document).ready(function () {
            var $parent,
                windowWidth,
                windowHeight;

            function winSize() {
                windowWidth = $(window).width(),
                    windowHeight = $(window).height();
            }

            winSize();
            $(window).resize(winSize);
            $('.drag-tooltip').each(function () {

                $(this).parent().hover(function () {
                    $(this).find('.drag-tooltip').fadeIn('fast');
                }, function () {
                    $(this).find('.drag-tooltip').fadeOut('fast');
                });

            });

            $(document).mousemove(function (e) {
                var mouseY = e.clientY,
                    mouseX = e.clientX,
                    tooltipHeight,
                    tooltipWidth;

                $('.drag-tooltip').each(function () {
                    var $tooltip = $(this);
                    tooltipHeight = $tooltip.outerHeight();
                    tooltipWidth = $tooltip.width();
                    $parent = $tooltip.parent();

                    $tooltip.css({
                        'left': mouseX,
                        'top': mouseY + 20
                    });

                    if (tooltipWidth + mouseX + 20 > windowWidth) {
                        $tooltip.css({
                            'left': mouseX - tooltipWidth - 20
                        });
                    }

                    if (tooltipHeight + mouseY + 20 > windowHeight) {
                        $tooltip.css({
                            'top': mouseY - 20 - tooltipHeight
                        });
                    }
                });
            });
        });


        var colorList = ['000000', 'FFFFFF', 'ff0000', 'ffff00', '008000', '0000ff', 'ffa500', '800080',
            '808080'];
        var picker = $('#color-picker');

        for (var i = 0; i < colorList.length; i++) {
            picker.append('<li class="color-item" data-hex="' + '#' + colorList[i] + '" style="background-color:' + '#' + colorList[i] + ';"></li>');
        }

        $('body').click(function () {
            picker.hide();
        });
        $('.edit-bike').click(function () {
            $('.edit-bike-form').submit();
        });

        $('.call-picker').click(function (event) {
            event.stopPropagation();
            picker.show();
            picker.children('li').hover(function () {
                var codeHex = $(this).data('hex');
                $('.color-holder').css('background-color', codeHex,);
                $('#hidden_color').val(codeHex);
            });
        });
    </script>
@endsection

