@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
@section('image')
    <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%">
@endsection
