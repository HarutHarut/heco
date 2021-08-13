@extends('.dashboard.layouts.app')


@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <div class="subheader-breadcrumbs">
                <a href="{{route('users.index')}}" class="breadcrumbs-link">{{__('dashboard_forms.users')}}</a>
                <span class="breadcrumbs-separator-dot"></span>
                <a href="{{route('users.edit', $user->id)}}" class="breadcrumbs-link">{{__('Edit User')}}
                    - {{$user->id}}</a>
            </div>
        </div>

        <div class="d-flex ml-auto">
            <a href="{{route('users.edit', [$user->id, 'sort' => request()->get('sort'), 'direction' => request()->get('direction')])}}"
               class="btn btn-secondary ml-2">{{__('Cancel')}}</a>
            <button type="submit" class="btn btn-primary ml-2" id="object-form-confirm">{{__('Save')}}</button>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-header">
                <h3 class="kt-portlet__head-title">
                    {{__('dashboard_forms.edit_user')}}
                </h3>
            </div>

            <div class="card-body">
                {!! Form::model($user, [
                         'method' => 'PATCH',
                         'files' => true,
                         'id' => 'object-form',
                         'url' => route('users.update',[
                             'page' => request()->get('page'),
                             'sort' => request()->get('sort'),
                              'direction' => request()->get('direction'),
                               'search' => request()->get('search'),$user->id
                               ]),
                       ]) !!}
                @csrf
                @include('dashboard.users.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection

