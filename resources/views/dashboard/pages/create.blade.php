@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <div class="subheader-breadcrumbs">
                <a href="{{route('pages.index')}}" class="breadcrumbs-link">{{__('dashboard_forms.pages')}}</a>
                <span class="breadcrumbs-separator-dot"></span>
                <a class="breadcrumbs-link">{{__('dashboard_forms.create_now_page')}}</a>
            </div>
        </div>

        <div class="d-flex ml-auto">
            <a href="{{route('pages.create')}}" class="btn btn-secondary ml-2">{{__('dashboard_forms.cancel')}}</a>
            <button type="submit" class="btn btn-primary ml-2" id="object-form-confirm">{{__('dashboard_forms.save')}}</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-header">
                <h3 class="kt-portlet__head-title">
                    {{__('dashboard_forms.create_now_page')}}
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ route('pages.store') }}" method="post" id="object-form"
                      class="kt-form kt-form--label-right"
                      enctype="multipart/form-data">
                    @csrf
                    @include('dashboard.pages.form')
                </form>
            </div>

        </div>
    </div>

@endsection
