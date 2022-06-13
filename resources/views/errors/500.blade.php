@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('image')
    <img src="{{ url('/img/errors/podarcis.jpg') }}" alt="suerte" style="width: 100%; height: auto">
    {{-- <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%"> --}}
@endsection
