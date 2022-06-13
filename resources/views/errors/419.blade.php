@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@section('image')
    <img src="{{ url('/img/errors/saludos.gif') }}" alt="suerte" style="width: 100%">
@endsection
