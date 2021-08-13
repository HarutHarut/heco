{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
<div class="d-flex align-items-center">
    <label>{{$text[0]}}</label>
    <span class="kt-switch kt-switch--icon mr-3 ml-3">
        <label>
            {!! Form::checkbox($name, $value ?? 1, $checked ?? false, ['class' => 'form-input-styled']); !!}
            <span></span>
        </label>
    </span>
    <label>{{$text[1]}}</label>
</div>
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
