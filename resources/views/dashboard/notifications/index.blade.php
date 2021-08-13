@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.notifications')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')
                <form action="{{route('notifications.index')}}" method="GET"
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
                            <th>@sortablelink('id', __('dashboard_forms.ID') ,['page' => Request::get('page'), 'search' =>
                                Request::get('search')])
                            </th>
                            <th>{{__('dashboard_forms.user_name')}}</th>
                            <th>{{__('dashboard_forms.user_email')}}</th>
                            <th>{{__('dashboard_forms.brand')}}</th>
                            <th>{{__('dashboard_forms.model')}}</th>
                            <th>@sortablelink('year', __('dashboard_forms.year') ,['page' => Request::get('page'), 'search'
                                => Request::get('search')])
                            </th>
                            <th>@sortablelink('created_at', __('dashboard_forms.created_at') ,['page' =>
                                Request::get('page'), 'search'
                                => Request::get('search')])
                            </th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bikes as $bike)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{$bike->id}}</td>
                                <td data-label="{{__('dashboard_forms.user_name')}}">{{$bike->user->name ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.user_email')}}">{{$bike->user->email ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.brand')}}">{{$bike->brand->name ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.model')}}">{{$bike->model->name ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.year')}}">{{$bike->year ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.created_at')}}">{{$bike->created_at}}</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        @if($bike->send_request == 0)
                                            <a href="{{ route('bikes.edit', [$bike->id, 'type' => 'approved','page' => request()->page, 'sort' => request()->get('sort'), 'direction' => request()->get('direction')]) }}"
                                               class="btn" title="{{__('Edit details')}}"
                                               onclick="return confirm('dashboard_success.Are You Sure?')">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @else
                                            @if($bike->send_request == 1)
                                                <a href="{{ route('shop.bike', $bike->slug) }}"
                                                   class="btn" title="{{__('Show')}}" target="_blank">
                                                    <i class="fa flaticon-eye"></i>
                                                </a>
                                                <a class="btn" title="{{__('Checked')}}">
                                                    <i class="fa fa-check"
                                                       style="color: green!important;"></i>
                                                </a>
                                            @endif
                                        @endif
                                        @if($bike->send_request == 0)
                                            <a href="{{ route('notifications.edit', [$bike->id, 'type' => 'rejected','page' => request()->page, 'sort' => request()->get('sort'), 'direction' => request()->get('direction')]) }}"
                                               class="btn" title="{{__('Reject')}}"
                                               onclick="return confirm('dashboard_success.Are You Sure?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @else
                                            @if($bike->send_request == -1)
                                                <a class="btn" title="{{__('Reject')}}">
                                                    <i class="fas fa-times"
                                                       style="color: red!important;"></i>
                                                </a>
                                            @endif
                                        @endif

                                        <form action="{{ route('notifications.destroy', $bike->id) }}" method="POST"
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
                        {!! $bikes->appends(['search' => Request::get('search'), 'sort' => Request::get('sort'), 'direction' => Request::get('direction')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>
            </div>
        </div>
    </div>


@endsection

