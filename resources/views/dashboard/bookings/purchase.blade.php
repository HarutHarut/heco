@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.purchase')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
        <div class="ml-auto d-flex">
            <form action="{{route('purchase.export')}}" method="POST" class="mr-1">
                @csrf
                <button type="submit" class="btn btn-primary">  <i class="flaticon2-download mr-2"></i> {{__('dashboard_forms.export')}}</button>
            </form>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <form action="{{route('purchase')}}" method="GET"
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
                            <th>{{__('dashboard_forms.bike')}}</th>
                            <th>@sortablelink('updated_at', __('dashboard_forms.sell_date') ,['page' =>
                                Request::get('page'), 'search' => Request::get('search')])
                            </th>
                            <th>@sortablelink('price', __('dashboard_forms.price') ,['page' => Request::get('page'),
                                'search' => Request::get('search')])
                            </th>
                            <th>{{__('dashboard_forms.Comon_selling_price')}}</th>
                            <th>{{__('dashboard_forms.package')}}</th>
                            <th>@sortablelink('shipping', __('dashboard_forms.shipping') ,['page' =>
                                Request::get('page'),
                                'search' => Request::get('search')])
                            </th>
                            <th>{{__('dashboard_forms.seller')}}</th>
                            <th>{{__('dashboard_forms.buyer')}}</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($purchases as $purchase)
                            <tr>
                                <td data-label="{{__('dashboard_forms.ID')}}">
                                    {{ $purchase->id }}
                                </td>
                                <td data-label="{{__('dashboard_forms.bike')}}">
                                    <div class="d-lg-flex align-items-start">
                                        <img
                                            src="{{$purchase->bike ? $purchase->bike->image('top') :  '/img/heco-1.png'}}"
                                            alt="Diverge E5 Base" width="85" height="" loading="lazy"
                                            class="border rounded-lg">
                                        <div class="ml-2">
                                            <p class="mb-0"><b>{{ $purchase->bike->name ?? '' }}</b></p>
                                            <div>
                                                <div>
                                                    <span>{{__('dashboard_forms.year')}}</span>
                                                    <span>{{ $purchase->bike->year ?? ''}}</span>
                                                </div>
                                                <div>
                                                    <span>{{__('dashboard_forms.size')}}</span>
                                                    <span>{{ $purchase->bike->frame_size ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="{{__('dashboard_forms.sell_date')}}">{{ \Carbon\Carbon::parse($purchase->created_at)->format('d.m.Y') }}</td>
                                <td data-label="{{__('dashboard_forms.price')}}">{{ $purchase->format_price }} €</td>
                                @php
                                    $price_min = 0;
                                    $price_max = 0;
                                    if ($purchase->bike){
                                        $years = \Carbon\Carbon::now()->year - $purchase->bike->year;
                                        $condition = $purchase->bike->condition;
                                        $min = config("condition.$condition.min");
                                        $max = config("condition.$condition.max");
                                        $price_min = round($purchase->bike->msrp * $min[$years] / 100, 2);
                                        $price_max = round($purchase->bike->msrp * $max[$years] / 100, 2);
                                    }
                                @endphp
                                <td data-label="{{__('dashboard_forms.mrsp')}}">{{ $price_min }} € - {{ $price_max }} €</td>
                                <td data-label="{{__('dashboard_forms.package')}}">{{__("dashboard_forms.$purchase->package_name")}}</td>
                                <td data-label="{{__('dashboard_forms.shipping')}}">{{$purchase->is_shipping ? __('dashboard_forms.yes') : __('dashboard_forms.no')}}</td>
                                <td data-label="{{__('dashboard_forms.seller')}}">{{ $purchase->bike->user->name}}
                                    <br>
                                    {{ $purchase->bike->user->city}}, {{ $purchase->bike->user->street}} {{$purchase->bike->user->house_number}}, {{$purchase->bike->user->zip}}
                                </td>
                                <td data-label="{{__('dashboard_forms.buyer')}}">{{ $purchase->user->name }} ({{$purchase->user->email}})<br>
                                    {{ $purchase->city}}, {{ $purchase->street}} {{$purchase->house_number}}, {{$purchase->zip}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                        {!! $purchases->appends(['search' => Request::get('search'), 'sort' => Request::get('sort'), 'direction' => Request::get('direction')])->render("pagination::bootstrap-4") !!}
                    </ul>
                </nav>

            </div>
        </div>
    </div>

@endsection



