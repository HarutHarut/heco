{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
<input type="date" name="{{$name}}" id="{{$name}}" class="form-control"  placeholder="{{__(ucfirst(str_replace('_', ' ', $name)))}}" value="{{(old($name)) ? old($name) : (isset($object) && $object ? $object->publish_date->format('Y-m-d') : null)}}">
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
