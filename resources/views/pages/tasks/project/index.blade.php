@extends('layouts.app')

@section('content')
<div class="row mb-2">
    <div class="col-10 my-auto">
        <h2>{{ __('modules.tasks') }}</h2>
        <ol class="breadcrumb">

            <li class="breadcrumb-item active">
                <strong>{{ __('modules.projects') }}</strong>
            </li>
        </ol>

        <a href="{{ route('tasks.project.create') }}" class="btn btn-primary">
            {{ __('forms.create') }}
        </a>
    </div>

    <div class="col-2 text-right">
        <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
    </div>

</div>

<div class="row">
    @foreach ($projects as $key => $project)
    <div class="col-md-3 mt-4">
        <div class="ibox h-100">
            <div class="ibox-content h-75">
                <h3 class="text-center">
                    {{ $project->name }}
                </h3>

                <div class="text-justify">
                    {!! $project ->description !!}
                </div>

            </div>

            <div class="ibox-footer h-25 my-auto">
                <div class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('tasks.project.edit', $project->token) }}" class="btn btn-primary">
                            Editar
                        </a>

                        <a href="{{ route('tasks.project.details', $project->token) }}" class="btn btn-success">
                            Ver
                        </a>

                        <button class="btn btn-danger" onclick="remove('{{ $project->token }}')">
                            Borrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>


@foreach ($projects as $project)
<form action="{{ route('tasks.project.delete') }}" id="delete_{{ $project->token }}" method="POST">
    @csrf
    @method('put')
    <input name="token" type="hidden" value="{{ $project->token }}">
</form>
@endforeach
@endsection

@push('scripts')

<script src="{{ url('/') }}/js/tables.js"></script>

<script>
    function remove(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this project!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarlo",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }
</script>

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