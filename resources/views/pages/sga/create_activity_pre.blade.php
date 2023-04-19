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
                    <strong>{{ __('forms.create') }} Actividad</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('sga.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>
    <div class="ibox">
        <div class="ibox-title">
            <h5><b>Crear actividad:</b></h5>
            <div class="ibox-tools">
                <a class="collapse-link" href=""><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="w-100 ">
                <form action="{{ route('sga.store_activity_pre') }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">



                        <div class="form-group col-6">
                            <label for="name">Nombre:</label>
                            <input id="name" name="name" class="form-control" placeholder="Nombre..."
                                type="text">
                        </div>

                        <div class="form-group col-6">
                            <label for="name">Tipo de proceso:</label>
                            <select name="process_type_id" class="form-control" id="process_type_id">

                                @foreach ($tiposProcesos as $tipoProceso)
                                    <option value="{{ $tipoProceso->id }}">
                                        {{ $tipoProceso->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-12 text-right">
                            <button class="btn btn-primary mt-auto">Guardar</button>
                        </div>

                    </div>




                </form>
            </div>


        </div>
        <div class="ibox-footer">Podarcis SL. &copy; {{ date('Y') }}</div>
    </div>
@endsection
