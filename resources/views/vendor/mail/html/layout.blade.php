@extends('emails.layouts.app')
@section('content')
{{ Illuminate\Mail\Markdown::parse($slot) }}
@endsection


