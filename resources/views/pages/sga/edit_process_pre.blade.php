@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.sga') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('sga.index') }}">{{ __('modules.sga') }}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.edit') }} Proceso</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('sga.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5><b>Editar proceso</b></h5>
            <div class="ibox-tools">
                <a class="collapse-link" href=""><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="ibox-content">

            <form action="{{ route('sga.update_process_pre') }}" method="post">
                @csrf
                @method('put')

                {{-- UPDATEAR LOS 4 ULTIMOS FORM --}}
                {{-- <input type="hidden" name="id" value="{{ $proceso->id }}">

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input id="name" name="name" class="form-control" placeholder="Nombre..."
                        value="{{ $proceso->name }}" type="text">
                </div> --}}

                {{-- name --}}
                <input type="hidden" name="id" value="{{ $proceso->id }}">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input id="name" name="name" class="form-control" placeholder="Nombre..."
                                value="{{ $proceso->name }}" type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        {{-- responsable --}}
                        <div class="form-group">
                            <label for="name">Responsable:</label>
                            <input id="name" name="responsable" class="form-control" placeholder="Responsable..."
                                value="{{ $proceso->responsable }}" type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        {{-- objetivo --}}
                        <div class="form-group">
                            <label for="name">Objetivo:</label>
                            <input id="name" name="target" class="form-control" placeholder="Objetivo..."
                                value="{{ $proceso->target }}" type="text">
                        </div>
                    </div>
                    <div class="col-6">

                        {{-- tipo de proceso --}}
                        <div class="form-group">
                            <label for="process_type_id">Tipo de proceso:</label>
                            <select name="process_type_id" class="form-control" id="process_type_id">

                                @foreach ($tiposProcesos as $tipoProceso)
                                    @if ($tipoProceso->id == $proceso->process_type_id)
                                        <option value="{{ $tipoProceso->id }}" selected> {{ $tipoProceso->name }}
                                        </option>
                                    @else
                                        <option value="{{ $tipoProceso->id }}"> {{ $tipoProceso->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>








                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($activities as $actividad)
                            <tr>
                                <td class="text-center">
                                    <input id="checkBox{{ $actividad->id }}" type="checkbox" name="activities[]"
                                        value="{{ $actividad->id }}" class="js-switch">

                                </td>
                                <td>
                                    {{ $actividad->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right">
                    <button class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
        <div class="ibox-footer">Podarcis SL. &copy; {{ date('Y') }}</div>
    </div>
@endsection

@push('scripts')
    @foreach ($activities as $actividad)
        @foreach ($proceso->activities_pre as $actividad_proceso)
            @if ($actividad_proceso->id == $actividad->id)
                <script>
                    $("#checkBox{{ $actividad->id }}").prop("checked", true)
                </script>
            @endif
        @endforeach
    @endforeach
@endpush
