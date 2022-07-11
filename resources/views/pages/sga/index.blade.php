@extends('layouts.app')

@section('content')
    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li><a id="nav-actividades" class="nav-link active bg-transparent" data-toggle="tab"
                    href="#tab-actividades">Actividades</a></li>
            <li><a id="nav-procesos" class="nav-link bg-transparent" data-toggle="tab" href="#tab-procesos">Procesos</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" id="tab-actividades" class="tab-pane active">
                <div class="panel-body bg-transparent">

                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5><b>Actividades</b></h5>
                            <br>

                            @can('store SGA')
                                <a class="btn btn-primary" href="{{ route('sga.create_activity_pre') }}">
                                    {{ __('forms.create') }}...
                                </a>
                            @endcan
                            <div class="ibox-tools">
                                <a class="collapse-link" href="">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            {{-- table --}}
                            <div class="container-fluid table-responsive">
                                <table class="table table-striped table-bordered table-hover js_datatable">

                                    <thead>
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Acciones</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($actividades as $key => $actividad)
                                            <tr>

                                                <td>
                                                    {{ $actividad->name }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('sga.edit_activity_pre', $actividad->id) }}"
                                                        class="btn btn-link">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>

                                                    </a>

                                                    <button onclick="removeActivity('{{ $actividad->id }}')"
                                                        class="btn btn-link">
                                                        <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>

                                </table>
                            </div>
                            @foreach ($actividades as $key => $actividad)
                                <form id="deleteActivity_{{ $actividad->id }}"
                                    action="{{ route('sga.delete_activity_pre') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $actividad->id }}">
                                </form>
                            @endforeach



                        </div>
                        <div class="ibox-footer">
                            Podarcis SL. &copy; {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" id="tab-procesos" class="tab-pane">

                <div class="panel-body bg-transparent">

                    <div class="ibox">
                        <div class="ibox-title">

                            <h5><b>Procesos</b></h5>
                            <br>
                            @can('store SGA')
                                <a class="btn btn-primary" href="{{ route('sga.create_process_pre') }}">
                                    {{ __('forms.create') }}...
                                </a>
                            @endcan
                            <div class="ibox-tools">
                                <a class="collapse-link" href="">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            Nombre
                                        </th>
                                        <th>
                                            Responsable
                                        </th>
                                        <th>
                                            Objetivo
                                        </th>
                                        <th>
                                            Tipo de proceso
                                        </th>
                                        <th>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($procesos as $key => $proceso)
                                        <tr>
                                            <td>
                                                {{ $proceso->name }}
                                            </td>
                                            <td>
                                                {{ $proceso->responsable }}
                                            </td>
                                            <td>
                                                {{ $proceso->target }}
                                            </td>
                                            <td>
                                                {{ $proceso->process_type->name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('sga.edit_process_pre', $proceso->id) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>

                                                </a>
                                                <button onclick="removeProcess('{{ $proceso->id }}')"
                                                    class="btn btn-link">
                                                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach ($procesos as $key => $proceso)
                                        <form id="deleteProcess_{{ $proceso->id }}"
                                            action="{{ route('sga.delete_process_pre') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $proceso->id }}">
                                        </form>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>

                        <div class="ibox-footer"> Podarcis SL. &copy; {{ date('Y') }}</div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{ url('/') }}/js/tables.js"></script>

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

    {{-- DELETE ACTIVITY --}}
    <script>
        function removeActivity(id) {
            //PROMESA
            swal({
                title: "¿Estás seguro?",
                text: "¡No podrá recuperar esta actividad!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonText: "Cancelar",
            }, function() {
                $("#deleteActivity_" + id).submit();
                swal("Listo!", "Actividad borrada con éxito.", "success");
            });
        }
    </script>

    {{-- DELETE PROCESS --}}
    <script>
        function removeProcess(id) {
            //PROMESA
            swal({
                title: "¿Estás seguro?",
                text: "¡No podrá recuperar este proceso!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarlo",
                closeOnConfirm: false,
                cancelButtonText: "Cancelar",
            }, function() {
                $("#deleteProcess_" + id).submit();
                swal("Listo!", "Proceso borrado con éxito.", "success");
            });
        }
    </script>

    <script>
        $('#nav-actividades').on('click', () => {
            localStorage.setItem('superadminSgaTab', 'nav-actividades');
        });

        $('#nav-procesos').on('click', () => {
            localStorage.setItem('superadminSgaTab', 'nav-procesos');
        });

        if (localStorage.getItem('superadminSgaTab') == "nav-actividades") {

            $('#nav-actividades').tab('show') // Select tab
        } else if (localStorage.getItem('superadminSgaTab') == "nav-procesos") {

            $('#nav-procesos').tab('show') // Select tab
        }
    </script>
@endpush
