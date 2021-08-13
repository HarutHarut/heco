{{--{!! Form::label($name, $label ?? __(ucfirst(str_replace('_', ' ', $name)))) !!}--}}
<div class="input-group">
<span class="input-group-btn">
<label for="{{$name}}_lfm" data-input="{{$name}}_thumbnail" data-preview="{{$name}}_holder"
       class="btn btn-primary text-white">
    <i class="flaticon2-photo-camera" style="color: #fff"></i> {{__('Choose ' . ucfirst(str_replace('_', ' ', $name)))}}</label>
</span>
    <input id="{{$name}}_lfm" class="form-control d-none" type="file" name="{{$name}}" {{$multiple ?? ''}}>
</div>

@if(isset($object) && $object)
    <div id="{{$name}}_holder" style="margin-top:15px;max-height:100px;">
        <img src="{{Storage::url($object->image)}}" style="height: 5rem" alt="{{$name}}">
    </div>
@else
    <div id="{{$name}}_holder" style="margin-top:15px;max-height:100px;"></div>
@endif

@if(isset($image) && $image)
    @if(isset($multiple))
        <div id="{{$name}}_holder" style="margin-top:15px;max-height:100px;">
        @foreach($image as $path)
                <img src="{{Storage::url($path)}}" style="height: 5rem" alt="{{$name}}">
        @endforeach
        </div>

    @else
        <div id="{{$name}}_holder" style="margin-top:15px;max-height:100px;">
            <img src="{{Storage::url($image)}}" style="height: 5rem" alt="{{$name}}">
        </div>

    @endif
@else
    <div id="{{$name}}_holder" style="margin-top:15px;max-height:100px;"></div>
@endif

{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}

