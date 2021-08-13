@extends('layouts.app')

@section('PageCss')
    <link rel="stylesheet" href="/css/crop.css">
    <link href="{{mix('/css/profile.css')}}" rel="stylesheet">
    <link href="/css/toastr.min.css" rel="stylesheet">
@endsection

@section('content')

    <section class="profile-page">

        @include('profile.menu')

        <div class="profile-container">
            <div class="profile-content">
                <div class="payment-block">
                    <p>{{__('Payout first text')}}</p>
                    <p>{{__('Payout second text')}}</p>
                    <hr>
                    <div class="d-flex flex-wrap align-items-start">
                        <div>
                            @if(auth()->user()->account)
                                <table class="table mb-4">
                                    <tbody>
                                    <tr>
                                        <th class="border-top-0">{{__('Account number')}}</th>
                                        <td class="border-top-0">{{auth()->user()->account->account_number}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-top-0">{{__('Personal ID number')}}</th>
                                        <td class="border-top-0">{{auth()->user()->account->personal_id_number}}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-top-0">{{__('Status')}}</th>
                                        <td class="border-top-0">{{$account->legal_entity->verification->status}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex payment-block-buttons">
                                    <a href="#" data-hystmodal="#AccoutnEdit" class="btn btn_green">{{__('Edit')}}</a>
                                    @if($account->legal_entity->verification->status == 'unverified')
                                        <form action="{{route('account.update')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="account_number" value="{{auth()->user()->account->account_number}}">
                                            <input type="hidden" name="personal_id_number" value="{{auth()->user()->account->personal_id_number}}">
                                            <button class="btn btn_green" type="submit">{{__('Verify')}}</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <a href="#" data-hystmodal="#AccoutnEdit" class="btn btn_green">{{__('Add Account')}}</a>
                            @endif
                        </div>
                        <div class="ml-auto">
                            <form action="{{route('payout')}}" method="POST" class="d-flex flex-column text-center order-user">
                                @csrf
                                <span><b>{{__('Balance')}}</b></span>
                                <span class="text-green">{{$balance / 100}} EUR</span>
                                @if(auth()->user()->account && $balance > 0)
                                    <button type="submit" class="btn btn_green">{{__('Payout')}}</button>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div>
                         @if($account && count($account->verification->fields_needed))
                            <hr>
                            <h3><b>{{__("Fields needed for verification")}}</b></h3>
                            @foreach($account->verification->fields_needed as $field)
                                <p class="text-red">{{ucfirst(str_replace('_', ' ', str_replace('.', ' -> ', $field)))}}</p>
                            @endforeach
                            <hr>

                            <form action="{{route('account.file', 'identity_document')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="document" class="mb-10">
                                <button type="submit" class="btn btn_grey mb-10">{{__('Upload Identity Document')}}</button>
                            </form>
                            <br>
                            <form action="{{route('account.file', 'additional_verification')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="document" class="mb-10">
                                <button type="submit" class="btn btn_grey mb-10">{{__('Upload Additional Document')}}</button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="table-payment">
                    <h3>{{__('Payout history')}}</h3>
                    <table class="mobile-table">
                        <thead>
                        <tr>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Amount')}}</th>
                            <th>{{__('Created At')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payouts as $payout)
                            <tr>
                                <td data-label="{{__('ID')}}">{{$payout->id}}</td>
                                <td data-label="{{__('Amount')}}">{{$payout->amount / 100}} EUR</td>
                                <td data-label="{{__('Created At')}}">{{$payout->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>


    {{--        Components modal--}}
    <div class="hystmodal login-modal" id="AccoutnEdit" aria-hidden="true">
        <div class="hystmodal__wrap">
            <div class="hystmodal__window" role="dialog" aria-modal="true">
                <button data-hystclose class="hystmodal__close">{{__('Close')}}</button>

                <h2 class="font-light text-center modal-title">{{__('Account Details')}}</h2>

                <form @if(auth()->user()->account) action="{{route('account.update')}}" @else action="{{route('account.store')}}" @endif method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="account_number" value="{{auth()->user()->account->account_number ?? ''}}" placeholder="{{__('Account number')}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="personal_id_number" value="{{auth()->user()->account->personal_id_number ?? ''}}" placeholder="{{__('Personal ID number')}}" class="form-control">
                    </div>

                    <div class="text-right">
                        <button type="button" class="btn btn_green mr-2" data-hystclose class="hystmodal__close">{{__('Cancle')}}</button>
                        <button type="submit" class="btn btn_green">{{__('Save')}}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/crop.js"></script>
    <script src="/js/toastr.min.js" type="text/javascript"></script>
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

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000"
        };

        @foreach (session('flash_notification', collect())->toArray() as $message)
        toastr.{{$message['level']}}('{!! str_replace("'", '', $message['message']) !!}');
        @endforeach

    </script>


@endsection
