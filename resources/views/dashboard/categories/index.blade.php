@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.categories')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="ml-auto">
            <a href="{{route('categories.create')}}" class="btn btn-create">
                <i class="flaticon2-plus mr-2"></i>
                {{__('dashboard_forms.create_new_category')}}
            </a>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <div class="d-flex align-items-end justify-content-between flex-wrap">
                    <form action="{{route('categories.index')}}" method="GET" class="ml-auto mb-4">
                        <div class="search-block position-relative ml-auto">
                            <input type="search" placeholder="{{__('dashboard_forms.search')}}" name="search" class="form-control" value="{{request()->get('search')}}" aria-label="search">
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
                            <th>{{__('dashboard_forms.ID')}}</th>
                            <th>{{__('dashboard_forms.name')}}</th>
                            <th class="text-center" style="width: 90px">{{__('dashboard_forms.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">{{$category->id}}</td>
                                <td data-label="{{__('dashboard_forms.name')}}">{{$category->name}}</td>
                                <td data-label="{{__('dashboard_forms.actions')}}" class="table-buttons">
                                    <div class="text-center table-buttons">
                                        <a href="{{ route('categories.edit', [$category->id, 'page' => request()->page]) }}" class="btn" title="Edit details">
                                            <i class="flaticon-edit"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: none" onsubmit="return confirm('dashboard_success.Are You Sure?')">
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
                        {!! $categories->appends(['search' => Request::get('search')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>

            </div>
        </div>
    </div>

@endsection


