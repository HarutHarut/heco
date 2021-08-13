@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.change_password')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="d-flex ml-auto">
            <a href="{{route('change.index')}}" class="btn btn-secondary ml-2">{{__('dashboard_forms.cancel')}}</a>
            <button type="submit" class="btn btn-primary ml-2" id="object-form-confirm">{{__('dashboard_forms.save')}}</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">
                @include('flash::message')
                <form action="{{ route('change.store') }}" method="post" id="object-form"
                  class="kt-form kt-form--label-right"
                  enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <div class="kt-portlet__body border-12">
                        <div class="form-group row">
                            <div class="col-lg-6">
                                @include('dashboard.components.form._password', (['name' => 'current_password']))
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                @include('dashboard.components.form._password', (['name' => 'password']))
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                @include('dashboard.components.form._password', (['name' => 'password_confirmation']))
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection

