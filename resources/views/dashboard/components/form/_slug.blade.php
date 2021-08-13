{!! Form::label($name, __('Friendly URL')) !!}
<div class="input-group">
    <span class="slugSpan">{{$text}}</span>
    {!! Form::text($name, $value ?? null, ['id' => $name, 'class' => 'form-control', 'placeholder' => __(ucfirst(str_replace('_', ' ', $name)))]) !!}
    <span class="slugSpan">/</span>
</div>
{!! $errors->first($name, '<span class="form-text text-danger">:message</span>') !!}
@section('css')
    <style>
        .slugSpan {
            background: lightgray;
            color: white;
            padding: 10px;
            border-radius: 3px;
        }
    </style>
@endsection
