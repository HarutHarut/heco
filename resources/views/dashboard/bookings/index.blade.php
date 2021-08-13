@extends('.dashboard.layouts.app')

@section('content')

    <div class="subheader flex-wrap">
        <div class="subheader-left pt-2 pb-2">
            <h3 class="subheader-left-title">{{__('dashboard_forms.bookings')}}</h3>
            <span class="subheader-left-separator"></span>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card mb-1">
            <div class="card-body">

                @include('flash::message')

                <div class="d-flex align-items-end justify-content-between flex-wrap">
                <form action="{{route('bookings.index')}}" id="search_form" method="GET" class="ml-auto mb-4">
                    <div class="search-block position-relative d-flex ml-auto">
                        <select name="status" id="status" class="form-control">
                            <option value="">{{__('dashboard_forms.all')}}</option>
                            <option value="new" @if(request()->get('status') == 'new') selected @endif>New</option>
                            <option value="pending" @if(request()->get('status') == 'pending') selected @endif>Pending</option>
                            <option value="paid" @if(request()->get('status') == 'paid') selected @endif>Paid</option>
                            <option value="success" @if(request()->get('status') == 'success') selected @endif>Success</option>
                        </select>
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
                        <th>{{__('dashboard_forms.seller')}}</th>
                        <th>{{__('dashboard_forms.buyer')}}</th>
                        <th>{{__('dashboard_forms.bike_name')}}</th>
                        <th>{{__('dashboard_forms.package')}}</th>
                        <th>{{__('dashboard_forms.price')}}</th>
                        <th>{{__('dashboard_forms.status')}}</th>
                        <th>{{__('dashboard_forms.confirmed by')}}</th>
                        <th>{{__('dashboard_forms.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{$booking->id}}</td>
                            <td data-label="{{__('dashboard_forms.seller')}}">{{ $booking->bike->user->name}}
                                <br>
                                {{ $booking->bike->user->city}}, {{ $booking->bike->user->street}} {{$booking->bike->user->house_number}}, {{$booking->bike->user->zip}}
                            </td>
                            <td data-label="{{__('dashboard_forms.buyer')}}">{{ $booking->user->name }} ({{$booking->user->email}})<br>
                                {{ $booking->city}}, {{ $booking->street}} {{$booking->house_number}}, {{$booking->zip}}
                            </td>
                            <td>{{$booking->bike->name}}</td>
                            <td>{{__("dashboard_forms.$booking->package_name")}}</td>
                            <td>{{$booking->format_price}}</td>
                            <td>{{$booking->status}}</td>
                            <td>{{(($booking->seller_confirm) ? __('dashboard_forms.seller') : '') . ' ' .($booking->seller_confirm && $booking->buyer_confirm ? __('dashboard_forms.and') : '') . ' ' . (($booking->buyer_confirm) ? __('dashboard_forms.buyer') : '')}}</td>
                            <td>
                                @if($booking->status == 'paid')
                                <form action="{{route('pay.conmfirm', $booking->id)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">{{__('dashboard_forms.confirm')}}</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-end">
                        {!! $bookings->appends(['search' => Request::get('search'), 'status' => Request::get('status')])->render("pagination::bootstrap-4") !!}
                    </ul>
            </nav>
            </div>
        </div>
    </div>
@endsection
@section('dashboard-js')
    <script>
        $('#status').change(function (){
            $('#search_form').submit();
        })
    </script>
@endsection

