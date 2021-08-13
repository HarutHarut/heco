{!! Form::label(isset($title) ? $title : $name, __(ucfirst(str_replace('_', ' ', isset($title) ? $title : $name)))) !!}
{!! Form::text($name, $value ?? null, ['id' => isset($id) ? $id : $name, 'class' => 'form-control', 'placeholder' => __(ucfirst(str_replace('_', ' ', isset($title) ? $title : $name)))]) !!}
{!! $errors->first($error_name ?? $name, '<span class="form-text text-danger">:message</span>') !!}
