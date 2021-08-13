{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
{!! Form::email($name, $value ?? null, ['id' => $name, 'class' => 'form-control', 'readonly' => (isset($readonly) && $readonly) ? true : false, 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
