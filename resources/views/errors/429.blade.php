@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
@section('image')
    <img src="{{ url('/img/errors/podarcis.jpg') }}" alt="suerte" style="width: 100%; height: auto">
    {{-- <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%"> --}}
@endsection
