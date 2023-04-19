@extends ("layouts.app")


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
            <h5>
                <b>Crear procesos
                    {{ mb_strtolower($processType->name, 'UTF-8') == 'soporte' ? 'de' : '' }}
                    {{ mb_strtolower($processType->name, 'UTF-8') }}:
                </b>
            </h5>

            <div class="ibox-tools">
                <a class="collapse-link" href=""><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="ibox-content">

            <form action="{{ route('sga.store_process') }}" method="post">
                @csrf
                @method('put')
                <input type="hidden" name="type_process_id" value="{{ $processType->id }}">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group @error('name') has-error @enderror">
                            <label for="name"><b>Nombre:</b></label>
                            <input id="name" name="name" class="form-control" placeholder="Nombre..." type="text"
                                value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group @error('responsable') has-error @enderror">
                            <label for="responsable"><b>Responsable:</b></label>
                            <input id="responsable" name="responsable" class="form-control" placeholder="Responsable..."
                                type="text">
                            @error('responsable')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group @error('target') has-error @enderror">
                            <label for="target"><b>Objetivo:</b></label>
                            <textarea id="target" name="target" class="form-control" placeholder="Objetivo..." type="text"></textarea>
                            @error('target')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>


                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th colspan="2">Importar actividades predefinidas</th>
                        </tr>
                        <tr>
                            <td class="w-25 bg-white">
                                <b>Seleccionar</b>
                            </td>
                            <td class="bg-white">
                                <b>Nombre</b>
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($actividadesPredefinidas as $activity)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="activitiesPre[]" value="{{ $activity->id }}"
                                        class="js-switch">
                                </td>
                                <td>
                                    {{ $activity->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-secondary mb-2" onclick="addRow()">
                    Crear actividades
                </button>

                <table id="tablaEspecificas" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Actividades especificas</th>
                        </tr>
                    </thead>

                    <tbody>

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
    <script>
        function addRow() {
            $("#tablaEspecificas tbody").append(`
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <input type="text" name="activities[]" class="form-control" placeholder="Acción...">
                                                                        </td>
                                                                    </tr>
                                                                `);
        }
    </script>
@endpush
