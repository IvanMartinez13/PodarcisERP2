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
                <a href="{{ route('teams.index') }}">{{ __('modules.teams') }}</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>{{ __('forms.create') }}</strong>
            </li>
        </ol>
    </div>

    <div class="col-2 text-right">
        <a href="{{ route('teams.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
    </div>

</div>

<div class="ibox">
    <div class="ibox-title">
        <h5>{{ __('forms.create')." ".__('modules.teams') }}</h5>

        <div class="ibox-tools">
            <a class="collapse-link" href="#">
                <i class="fa fa-chevron-up" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="ibox-content">
        <form action="{{route('teams.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-lg-6 mb-4 @error('name') has-error @enderror">
                    <label for="name">{{__('forms.name')}}:</label>
                    <input name="name" id="name" class="form-control" placeholder="{{__('forms.name')}}..." value="{{old('name')}}" />
                </div>

                <div class="col-lg-6 mb-4 @error('image') has-error @enderror">
                    <label for="image">{{ __('forms.image') }}:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input id="image" type="file" name="image" class="custom-file-input">
                            <label class="custom-file-label" for="image">{{ __('forms.image') }}...</label>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-12 mb-4 @error('description') has-error @enderror">
                    <label for="description">{{__('forms.description')}}:</label>
                    <textarea name="description" id="description" class="form-control" placeholder="{{__('forms.description')}}..." rows="8">{{old('description')}}</textarea>
                </div>
    
                <div class="col-lg-12 mb-4 @error('users') has-error @enderror">
                    <label for="users">{{__('forms.users')}}:</label>
                    <select id="users" name="users[]" class="form-control" multiple>
                        @foreach ($users as $user)
                            <option value="{{$user->token}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    
            <div class="text-right">
                <button class="btn btn-primary">
                    {{__('forms.create')}}
                </button>
            </div>

        </form>

    </div>

    <div class="ibox-footer">
        Podarics SL. &copy; {{date('Y')}} 
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready( function(){

            $("#users").select2({
                theme: "bootstrap4",
                allowClear: true,
                placeholder: "{{__('forms.users')}}..."
            });

            bsCustomFileInput.init();
        } )
        
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif
@endpush