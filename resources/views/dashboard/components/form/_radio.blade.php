{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
    <div class="kt-radio-inline">
        <label class="kt-radio kt-radio--solid">
            {!! Form::radio($name, $values[0] ?? 1, $selected ?? true, ['class' => 'form-input-styled', 'data-fouc' => true]); !!}
            {{$text[0]}}
            <span></span>
        </label>

        <label class="kt-radio kt-radio--solid">
            {!! Form::radio($name, $values[1] ?? 0, $selected ?? false, ['class' => 'form-input-styled', 'data-fouc' => true]); !!}
            {{$text[1]}}
            <span></span>
        </label>
    </div>
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
