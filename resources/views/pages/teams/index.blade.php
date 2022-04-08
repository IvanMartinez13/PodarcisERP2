@extends('layouts.app')

@section('content')

    <div class="row mb-2">

        <div class="col-10 my-auto">
            <h2>{{ __('modules.teams') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.teams') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <a class="btn btn-primary" href="{{route('teams.create')}}">
        {{__('forms.create')}}
    </a>

    <div class="row my-4">
        @foreach ($teams as $team)

            <div class="col-lg-3">
                <div class="glassCard text-dark h-100">
                    <div class="team-marco">
                        <img src="{{url('/storage').$team->image}}" class="img-fluid" alt="">
                    </div>
                    <h5 class="text-center">{{ $team->name }}</h5>
                    <p>
                        {{$team->description}}
                    </p>
                    <div class="text-center">

                        <div class="btn-group">

                            @can('update Teams')
                                <a href="{{route('teams.edit', $team->token)}}" class="btn btn-link">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            @endcan

                            @can('delete Teams')
                                <button class="btn btn-link">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endcan

                        </div>
                    </div>

                </div>
            </div>

        @endforeach
    </div>
@endsection

@push('scripts')
    
    @if (session('status') == 'error')
        <script>
            $(document).ready(() => {
                toastr.error("{{ session('message') }}")
            })
        </script>
    @endif

    @if (session('status') == 'success')
        <script>
            $(document).ready(() => {
                toastr.success("{{ session('message') }}")
            })
        </script>
    @endif
@endpush