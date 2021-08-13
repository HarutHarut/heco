@extends('.dashboard.layouts.app')

@section('dashboard-css')
    <style>
        .fa-sort:before, .fa-sort-asc:before {
            content: "\f0de";
        }

        .fa-sort-down:before, .fa-sort-desc:before {
            content: "\f0dd";
        }

        .fa, .fas {
            font-weight: 900;
        }
    </style>
@stop

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.users')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="ml-auto d-flex">
            <form action="{{route('users.export')}}" method="POST" class="mr-1">
                @csrf
                <button type="submit" class="btn btn-primary">  <i class="flaticon2-download mr-2"></i> {{__('dashboard_forms.export')}}</button>
            </form>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                <div class="d-flex align-items-end justify-content-between flex-wrap">
                    <form action="{{ route('users.index') }}" method="GET" class="ml-auto mb-4">
                        <input type="hidden" name="sort" value="{{Request::get('sort')}}">
                        <input type="hidden" name="direction" value="{{Request::get('direction')}}">
                        <div class="search-block position-relative ml-auto">
                            <input name="search" type="search" placeholder="Search" class="form-control" aria-label="search"
                                   value="{{request()->get('search')}}">
                            <button type="submit" class="btn">
                                <i class="flaticon-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table mobile-table">
                        <thead>
                        <tr>
                            <th>@sortablelink('id', __('dashboard_forms.ID') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('first_name', __('dashboard_forms.first_name') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('last_name', __('dashboard_forms.last_name') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('email', __('dashboard_forms.email') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('created_at', __('dashboard_forms.created_at') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('status', __('dashboard_forms.status') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th>@sortablelink('emaiul_verified_at', __('dashboard_forms.is_verified') ,['page' => Request::get('page'), 'search' => Request::get('search')])</th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{ $user->id }}</td>
                                <td data-label="{{__('dashboard_forms.first_name')}}">{{ $user->first_name }}</td>
                                <td data-label="{{__('dashboard_forms.last_name')}}">{{ $user->last_name }}</td>
                                <td data-label="{{__('dashboard_forms.email')}}">{{ $user->email }}</td>
                                <td data-label="{{__('dashboard_forms.created_at')}}">{{ $user->created_at }}</td>
                                <td data-label="{{__('dashboard_forms.sratus')}}">{{ $user->status ? __('dashboard_forms.active') : __('dashboard_forms.inactive') }}</td>
                                <td data-label="{{__('dashboard_forms.is_verified')}}" class="table-buttons">@if($user->email_verified_at) <i class="flaticon2-check-mark"> </i>@endif</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        <a href="{{ route('users.edit', [$user->id,'page' => request()->page,'sort' => request()->get('sort'), 'direction' => request()->get('direction'),
                                                                                     'search' => request()->search]) }}" class="btn" title="Edit details">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', [$user->id,'page' => request()->page,'sort' => request()->get('sort'), 'direction' => request()->get('direction'),
                                                                                     'search' => request()->search]) }}" method="POST"
                                              style="display: none"
                                              onsubmit="return confirm('dashboard_success.Are You Sure?')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" onclick="$(this).prev().submit()" class="btn" title="{{__('Delete')}}">
                                            <i class="flaticon2-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                        {!! $users->appends(['search' => Request::get('search'), 'sort' => Request::get('sort'), 'direction' => Request::get('direction')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>

            </div>
        </div>
    </div>



@endsection



