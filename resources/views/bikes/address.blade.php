@extends('layouts.app')

@section('PageCss')
    <link href="{{mix('/css/sell.css')}}" rel="stylesheet">
@endsection

@section('content')


    <div class="sell-1-container">
        <h1>{{ __('Pickup Address') }}</h1>
    </div>
    <form action="{{ route('sell.address.store', $bike->id) }}" method="POST">
        @csrf
        <section class="sell-1">
            <div class="sell-1-container">
                <p>{{__('Please fill in the pickup address for delivery process')}}</p>
                <div class="sell-1-form">
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
                    <div class="form-group">
                        <input
                            type="text"
                            placeholder="{{__('Phone')}}"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            aria-label="{{__('Phone')}}"
                            value="{{ old('phone', $user->phone)}}"
                        >
                        @error('phone')
                        <div style="color: red">{{ $message }}</div>
                        @enderror
                    </div>
                    <br>

                    <div class="col-100 text-right">
                        <button type="submit" class="btn btn_green mt-22">{{__('Save')}}</button>
                    </div>
                </div>
            </div>
        </section>

    </form>

@endsection
