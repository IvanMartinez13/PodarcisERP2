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

<div class="row mb-5">
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

                <h5>Tareas: </h5>
                <span class="label label-danger mx-1">
                    {{ $project->countAltas() }}
                </span>

                <span class="label label-warning mx-1">
                    {{ $project->countMedias() }}
                </span>

                <span class="label label-primary mx-1">
                    {{ $project->countBajas() }}
                </span>

                <div class="mt-3">
                    @php
                    $totalTareas = count($project->tareas);
                    $progreso = 0;

                    foreach ($project->tareas as $key => $tarea) {
                    $progreso += $tarea->progress;
                    }

                    if($totalTareas > 0){
                    $progreso = $progreso/$totalTareas;
                    }
                    @endphp
                    <h5>Progreso: </h5>
                    <div class="progress m-b-1">
                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                            style="width: {{ round($progreso, 2) }}%;"></div>
                    </div>
                    <small>Completado en un <strong>{{ number_format($progreso, 2, ',', '.') }}%</strong>.</small>
                </div>


            </div>

            <div class="ibox-footer h-25 my-auto">
                <div class="text-center">
                    <div class="btn-group">

                        @can('update Tareas')
                        <a href="{{ route('tasks.project.edit', $project->token) }}" class="btn btn-primary">
                            Editar
                        </a>
                        @endcan

                        <a href="{{ route('tasks.project.details', $project->token) }}" class="btn btn-success">
                            Ver
                        </a>

                        @can('delete Tareas')

                        <button class="btn btn-danger" onclick="remove('{{ $project->token }}')">
                            Borrar
                        </button>
                        @endcan

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