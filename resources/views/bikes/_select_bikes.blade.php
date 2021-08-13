@foreach($bikes as $bike)
    <div class="sell-3-item">
        <picture>
            <img src="{{ $bike->side_image ?? $bike->image_path ?? '/img/sellbike-1.jpg' }}" alt="" width="260" height="249" loading="lazy">
        </picture>
        <div class="sell-3-item-info">

            <h3>{{ $bike->name }}</h3>
            <p>{{ $bike->year }}</p>
            <form action="{{ route('sell.select.store', $bike->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn_green">{{__('That´s my bike')}}</button>
            </form>

        </div>
    </div>
@endforeach
