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
                    <strong>{{ __('forms.create') }} Proceso</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('sga.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5><b>Crear proceso:</b></h5>
            <div class="ibox-tools">
                <a class="collapse-link" href=""><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="ibox-content">

            <form action="{{ route('sga.store_process_pre') }}" method="post">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"><b>Nombre:</b></label>
                            <input id="name" name="name" class="form-control" placeholder="Nombre..."
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"><b>Responsable:</b></label>
                            <input id="name" name="responsable" class="form-control" placeholder="Responsable..."
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name"><b>Objetivo:</b></label>
                            <input id="name" name="target" class="form-control" placeholder="Objetivo..."
                                type="text">
                        </div>
                    </div>
                    <div class="col-6">
                        {{-- HACER DESPLEGABLE --}}
                        <div class="form-group">
                            <label for="name"><b>Tipo de proceso:</b></label>
                            <select id="name" name="process_type_id" class="form-control"
                                placeholder="Tipo de proceso..." type="text">



                                @foreach ($tiposProcesos as $tipoProceso)
                                    <option value="{{ $tipoProceso->id }}"> {{ $tipoProceso->name }}</option>
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
                        @foreach ($activities as $activity)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="activities[]" value="{{ $activity->id }}"
                                        class="js-switch">
                                </td>
                                <td>
                                    {{ $activity->name }}
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


    {{-- </div>
    </div>
    </div>


    </div> --}}
@endsection
