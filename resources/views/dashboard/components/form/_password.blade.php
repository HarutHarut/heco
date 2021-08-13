{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
{!! Form::password($name, ['id' => $name, 'class' => 'form-control', 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
