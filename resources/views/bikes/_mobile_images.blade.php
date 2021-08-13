@foreach($bike->images as $image)
    <figure class="preview"><img class="img" src="{{'/storage/bikes/' . $image->imageable_id . '/thumb/210/' . $image->path}}">
        <span class="mainSpan" data-id="{{$image->id}}" data-type="{{$image->type}}">
            <span class="spanOne"></span><span class="spanTwo"></span>
        </span>
    </figure>
@endforeach
