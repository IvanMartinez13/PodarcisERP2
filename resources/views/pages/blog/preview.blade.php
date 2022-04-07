@extends('layouts.app')

@section('content')

    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.blog') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}">{{ __('modules.blog') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ $blog->title }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('blog.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{__('Preview')}} "{{$blog->title}}"</h5>

            <div class="ibox-tools">
                <a href="#" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <h2 class="text-center py-2">{{$blog->title}}</h2>

            @if ($blog->image)
                <div class="mx-auto my-4 container">
                    <img class="img-fluid" src="{{url('/storage').$blog->image}}" />
                </div>
            @endif
            <div class="container my-4">
                {!! $blog->content !!}
            </div>
           
            
        </div>
        <div class="ibox-footer">
            Podarcis SL &copy; {{date('Y')}}
        </div>
    </div>
@endsection