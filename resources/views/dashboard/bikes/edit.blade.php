@extends('.dashboard.layouts.app')


@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <div class="subheader-breadcrumbs">
                <a href="{{route('bikes.index')}}" class="breadcrumbs-link">{{__('dashboard_forms.bikes')}}</a>
                <span class="breadcrumbs-separator-dot"></span>
                <a href="{{route('bikes.edit', $bike->id)}}" class="breadcrumbs-link">{{__('dashboard_forms.edit_bike')}} - {{$bike->id}}</a>
            </div>
        </div>

        <div class="d-flex ml-auto">
            <a href="{{route('bikes.edit', [$bike->id,'page' => request()->page, 'category' => request()->get('category'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction'),
                                                                                    'parent' => request()->get('parent'), 'search' => request()->search])}}" class="btn btn-secondary ml-2">{{__('dashboard_forms.cancel')}}</a>
            <button type="submit" class="btn btn-primary ml-2" id="object-form-confirm">{{__('dashboard_forms.save')}}</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">

            <div class="card-header">
                <h3 class="kt-portlet__head-title">
                    {{__('dashboard_forms.edit_bike')}}
                </h3>
            </div>

            <div class="card-body">
                {!! Form::model($bike, [
                        'method' => 'PATCH',
                        'files' => true,
                        'id' => 'object-form',
                        'url' => route('bikes.update',[$bike->id, 'type' => request()->type, 'page' => request()->page,  'category' => request()->category, 'parent' => request()->parent ,'search' => request()->search, 'sort' => request()->get('sort'), 'direction' => request()->get('direction')]),
                      ]) !!}

                @csrf
                @include('dashboard.bikes.form')

                {!! Form::close() !!}
            </div>

        </div>
    </div>


@endsection


