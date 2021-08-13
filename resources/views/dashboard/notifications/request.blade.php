@extends('.dashboard.layouts.app')

@section('content')


    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.request')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <form action="{{route('newbike.index')}}" method="GET"
                      class="d-flex align-items-end justify-content-between flex-wrap mb-4 category-filter-form">
                    <input type="hidden" name="sort" value="{{Request::get('sort')}}">
                    <input type="hidden" name="direction" value="{{Request::get('direction')}}">
                    <div class="search-block position-relative ml-auto">
                        <input type="search" placeholder="{{__('dashboard_forms.search')}}" name="search"
                               class="form-control" value="{{request()->get('search')}}" aria-label="search">
                        <button type="submit" class="btn">
                            <i class="flaticon-search"></i>
                        </button>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table mobile-table">
                        <thead>
                        <tr>
                            <th>@sortablelink('id', __('dashboard_forms.ID') ,['page' => Request::get('page'), 'search'
                                =>
                                Request::get('search')])
                            </th>
                            <th>@sortablelink('brand', __('dashboard_forms.brand') ,['page' => Request::get('page'),
                                'search' =>
                                Request::get('search')])
                            </th>
                            <th>@sortablelink('model', __('dashboard_forms.model') ,['page' => Request::get('page'),
                                'search' =>
                                Request::get('search')])
                            </th>
                            <th>@sortablelink('year', __('dashboard_forms.year') ,['page' => Request::get('page'),
                                'search' =>
                                Request::get('search')])
                            </th>
                            <th>@sortablelink('email', __('dashboard_forms.email') ,['page' => Request::get('page'),
                                'search' =>
                                Request::get('search')])
                            </th>
                            <th>@sortablelink('created_at', __('dashboard_forms.created_at') ,['page' =>
                                Request::get('page'), 'search' =>
                                Request::get('search')])
                            </th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $bike)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{$bike->id}}</td>
                                <td data-label="{{__('dashboard_forms.brand')}}">{{$bike->brand}}</td>
                                <td data-label="{{__('dashboard_forms.model')}}">{{$bike->model}}</td>
                                <td data-label="{{__('dashboard_forms.year')}}">{{$bike->year}}</td>
                                <td data-label="{{__('dashboard_forms.email')}}">{{$bike->email}}</td>
                                <td data-label="{{__('dashboard_forms.created_at')}}">{{$bike->created_at}}</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        @if($bike->status == 0)
                                            <a href="{{ route('newbike.edit', [$bike->id, 'type' => 'request','page' => request()->page, 'sort' => request()->get('sort'), 'direction' => request()->get('direction'),'search' => request()->search]) }}"
                                               class="btn" title="Edit details"
                                               onclick="return confirm('dashboard_success.Are You Sure?')">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @else
                                            @if($bike->status == 1)
                                                <a class="btn" title="Chacked">
                                                    <i class="fa fa-check"
                                                       style="color: green!important;"></i>
                                                </a>
                                            @endif
                                        @endif
                                        @if($bike->status == 0)
                                            <a href="{{ route('newbike.edit', [$bike->id, 'type' => 'rejected', 'sort' => request()->get('sort'), 'direction' => request()->get('direction'),'page' => request()->page]) }}"
                                               class="btn" title="Reject"
                                               onclick="return confirm('dashboard_success.Are You Sure?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @else
                                            @if($bike->status == -1)
                                                <a class="btn" title="Reject">
                                                    <i class="fas fa-times"
                                                       style="color: red!important;"></i>
                                                </a>
                                            @endif
                                        @endif

                                        <form action="{{ route('newbike.destroy', [$bike->id, 'type' => 'rejected', 'sort' => request()->get('sort'), 'direction' => request()->get('direction'),'page' => request()->page]) }}" method="POST"
                                              style="display: none"
                                              onsubmit="return confirm('dashboard_success.Are You Sure?')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="#" onclick="$(this).prev().submit()" class="btn" title="Delete">
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
                        {!! $requests->appends(['search' => Request::get('search'), 'sort' => Request::get('sort'), 'direction' => Request::get('direction')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

@endsection

