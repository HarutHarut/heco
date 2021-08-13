{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
<input type="{{ $browserType === 'Chrome/Opera' ? 'datetime-local' : 'text' }}" name="{{$name}}" id="{{$name}}" class="form-control datetime-local"  placeholder="{{__(ucfirst(str_replace('_', ' ', $name)))}}" value="{{(old($name)) ?? old($name)}}">
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
