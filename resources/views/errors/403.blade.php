@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
@section('image')
    <img src="{{ url('/img/errors/podarcis.jpg') }}" alt="suerte" style="width: 100%; height: auto">
    {{-- <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%"> --}}
@endsection
