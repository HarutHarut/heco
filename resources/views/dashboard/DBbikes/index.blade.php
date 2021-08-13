@extends('.dashboard.layouts.app')

@section('content')
    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.DBbikes')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="ml-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                {{__('dashboard_forms.import_bikes')}}
            </button>
            <a href="{{route('DBbikes.create')}}" class="btn btn-create">
                <i class="flaticon2-plus mr-2"></i>
                {{__('dashboard_forms.create_new_bike')}}
            </a>

        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <form action="{{route('DBbikes.index')}}" method="GET"
                      class="d-flex align-items-end justify-content-between flex-wrap mb-4 category-filter-form">
                    <input type="hidden" name="sort" value="{{Request::get('sort')}}">
                    <input type="hidden" name="direction" value="{{Request::get('direction')}}">
                    <div class="d-flex align-items-center mr-3">
                        <div class="mr-4">
                            <label class="mb-1">{{__('dashboard_forms.categories')}}:</label>
                            <select class="form-control category-filter-bike" aria-label="category" name="category">
                                <option value="">{{__('dashboard_forms.all')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            @if(request()->get('category') == $category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                                => Request::get('search'), 'category' => Request::get('category')])
                            </th>
                            <th>@sortablelink('name', __('dashboard_forms.name') ,['page' => Request::get('page'),
                                'search' => Request::get('search'), 'category' => Request::get('category')])
                            </th>
                            <th>
                                @sortablelink('brand.name', __('dashboard_forms.brand') ,['page' => Request::get('page'),
                                'search' => Request::get('search'), 'category' => Request::get('category')])
                            </th>
                            <th>@sortablelink('year', __('dashboard_forms.year') ,['page' => Request::get('page'),
                                'search' => Request::get('search'), 'category' => Request::get('category')])
                            </th>
                            <th>@sortablelink('msrp', __('dashboard_forms.MSRP') ,['page' => Request::get('page'),
                                'search' => Request::get('search'), 'category' => Request::get('category')])
                            </th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bikes as $bike)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{$bike->id}}</td>
                                <td data-label="{{__('dashboard_forms.name')}}">{{$bike->name}}</td>
                                <td data-label="{{__('dashboard_forms.brand')}}">{{$bike->brand->name ?? ''}}</td>
                                <td data-label="{{__('dashboard_forms.year')}}">{{$bike->year}}</td>
                                <td data-label="{{__('dashboard_forms.MSRP')}}">{{$bike->msrp}}</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        <a href="{{ route('DBbikes.edit', [$bike->id,'page' => request()->page, 'category' => request()->get('category'), 'sort' => request()->get('sort'), 'direction' => request()->get('direction'),
                                                                                    'parent' => request()->get('parent'), 'search' => request()->search]) }}"
                                           class="btn" title="Edit details">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        <form action="{{ route('DBbikes.destroy', [$bike->id,'page' => request()->page, 'category' => request()->get('category'),'sort' => request()->get('sort'), 'direction' => request()->get('direction'),
                                                                                    'parent' => request()->get('parent'), 'search' => request()->search]) }}" method="POST"
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
                        {!! $bikes->appends(['search' => Request::get('search'),'parent' => Request::get('parent'),'category' => Request::get('category'), 'sort' => Request::get('sort'), 'direction' => Request::get('direction')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" method="POST" action="{{route('bikes.import')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">{{__('dashboard_forms.import_bikes')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard_forms.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('dashboard_forms.import')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection


