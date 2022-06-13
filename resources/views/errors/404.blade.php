@extends('errors::illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('image')
    <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%">
@endsection
