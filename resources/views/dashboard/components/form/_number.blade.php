
    {!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
    {!! Form::number($name, null, ['id' => $name, 'class' => 'form-control', 'min' => $min ?? false, 'max' => $max ?? false, 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
    {!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
