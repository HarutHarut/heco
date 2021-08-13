@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <div class="subheader-breadcrumbs">
                <a href="{{route('settings.index')}}" class="breadcrumbs-link">{{__('dashboard_forms.settings')}}</a>
                <span class="breadcrumbs-separator-dot"></span>
                <a href="{{route('settings.edit', $setting->id)}}" class="breadcrumbs-link">{{__('dashboard_forms.edit_setting')}} - {{$setting->id}}</a>
            </div>
        </div>

        <div class="d-flex ml-auto">
            <a href="{{route('settings.edit', $setting->id)}}" class="btn btn-secondary ml-2">{{__('dashboard_forms.cancel')}}</a>
            <button type="submit" class="btn btn-primary ml-2" id="object-form-confirm">{{__('dashboard_forms.save')}}</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-header">
                <h3 class="kt-portlet__head-title">
                    {{__('dashboard_forms.edit_setting')}}
                </h3>
            </div>

            <div class="card-body">
                {!! Form::model($setting, [
                         'method' => 'PATCH',
                         'files' => true,
                         'id' => 'object-form',
                         'url' => route('settings.update',[$setting->id, 'page' => request()->page]),
                       ]) !!}
                @csrf
                @include('dashboard.settings.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection
