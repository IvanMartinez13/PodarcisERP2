@extends('layouts.app')

@section('content')
<div class="row mb-2">

    <div class="col-10 my-auto">
        <h2>{{  $team->name }}</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('teams.index') }}">{{ __('modules.teams') }}</a>
            </li>

            <li class="breadcrumb-item active">
                <strong>{{ $team->name }}</strong>
            </li>
        </ol>
    </div>

    <div class="col-2 text-right">
        <a href="{{ route('teams.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
    </div>

</div>

<div class="ibox">
    <div class="ibox-title d-flex">

        <div class="teamIcon">
            <img src="/storage/{{$team->image}}">
        </div>

        <h5 class="my-auto ml-3">{{ $team->name }}</h5>

        <div class="ibox-tools">
            <a href="#" class="collapse-link">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
            </a>
        </div>

    </div>

    <div class="ibox-content">

        <div class="tabs-container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="home" aria-selected="true">Chat</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="partners-tab" data-toggle="tab" href="#partners" role="tab" aria-controls="profile" aria-selected="false">Participantes</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="contact" aria-selected="false">Recursos</a>
                </li>
            </ul>
            <div class="tab-content">

                {{-- CHAT --}}
                <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                    <div class="p-lg-2 panel-body">
                        <chat user="{{json_encode(auth()->user())}}" team="{{$team}}"></chat>
                    </div>
                </div>
                
                {{-- PARTNERS --}}
                <div class="tab-pane fade" id="partners" role="tabpanel" aria-labelledby="partners-tab">

                    <div class="p-lg-2 panel-body">

                        <div class="py-5">
                            @foreach ($team->users as $user)
                                @if ($user->id != auth()->user()->id)
                                    <div class="row mb-5">
                                        <div class="col-lg-3 text-lg-right text-center">
                                            <img class="rounded rounded-circle partner-photo" src="{{url('/')}}/storage{{$user->profile_photo}}" alt="">
                                        </div>

                                        <div class="col-lg-9 text-lg-left text-center">
                                            <h5>{{$user->name}}</h5>
                                            <p>{{$user->email}} <br/> {{$user->position}}</p>
                                        </div>
                                    </div>
                                @endif

                            @endforeach

                            <div class="row">
                                <div class="col-lg-3 text-lg-right text-center">
                                    <img class="rounded rounded-circle partner-photo" src="{{url('/')}}/storage{{auth()->user()->profile_photo}}" alt="">
                                </div>

                                <div class="col-lg-9 text-lg-left text-center">
                                    <h5>Tú</h5>
                                    <p>{{auth()->user()->email}} <br/> {{auth()->user()->position}}</p>
                                </div>
                            </div>

                        
                        </div>


                    </div>
                </div>

                {{-- RESOURCES --}}
                <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">

                    <div class="p-lg-2 panel-body">

                        <resources user="{{json_encode(auth()->user())}}" team="{{$team}}"></resources>

                    </div>

                </div>
            </div>
        </div>

    </div>



    <div class="ibox-footer">
        Podarcis SL. &copy; {{date('Y')}}
    </div>
</div>
@endsection