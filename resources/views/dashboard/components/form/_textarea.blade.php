{!! Form::label($name, __(ucfirst(str_replace('_', ' ', $name)))) !!}
{!! Form::textarea($name, $value ?? null, ['id' => $name, 'class' => 'form-control', 'rows' => $rows ?? 5, 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
{!! $errors->first($error_name ?? $name, '<span class="form-text text-danger">:message</span>') !!}

@if(isset($editor) && $editor == true)
    <script>

        var options = {
            allowedContent: true
        };

        CKEDITOR.replace('{{$name}}', options);

    </script>
@endif
