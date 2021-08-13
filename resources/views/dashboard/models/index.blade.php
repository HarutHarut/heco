@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.models')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="ml-auto">
            <a href="{{route('models.create')}}" class="btn btn-create">
                <i class="flaticon2-plus mr-2"></i>
                {{__('dashboard_forms.create_new_model')}}
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <form action="{{route('models.index')}}" method="GET"
                      class="d-flex align-items-end justify-content-between flex-wrap mb-4 category-filter-form">

                    <div class="d-flex align-items-center mr-3">
                        <label class="mr-3 mb-0">{{__('dashboard_forms.models')}}:</label>
                        <select class="form-control category-filter-bike" aria-label="brand" name="brand">
                            <option value="">All</option>
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}"
                                        @if(request()->get('brand_id') == $brand->id) selected @endif>{{$brand->name}}</option>
                            @endforeach
                        </select>
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
                            <th>{{__('dashboard_forms.ID')}}</th>
                            <th>{{__('dashboard_forms.name')}}</th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{$model->id}}</td>
                                <td data-label="{{__('dashboard_forms.name')}}">{{$model->name}}</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        <a href="{{ route('models.edit', [$model->id, 'page' => request()->page]) }}" class="btn" title="Edit details">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        <form action="{{ route('models.destroy', $model->id) }}" method="POST"
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
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        {!! $models->appends(['search' => Request::get('search'),'brand' => Request::get('brand')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>

            </div>
        </div>
    </div>

@endsection
