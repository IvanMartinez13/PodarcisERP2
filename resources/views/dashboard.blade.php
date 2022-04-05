@extends('layouts.app')

@section('content')
    @if (auth()->user()->hasRole('super-admin'))
        <div class="row">
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Clientes</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">

                        <h2> {{ count($customers) }} </h2>
                        <div class="m-t-sm small">Total de clientes.</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Módulos</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">
                        <h2> {{ count($modules) }}</h2>
                        <div class="m-t-sm small">Total de modulos.</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Espacio en disco</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">

                        <h2> {{ $size }} usados.</h2>

                        <div class="progress progress-mini">
                            <div style="width: {{ 100 - $restante * 100 }}%;" class="progress-bar"></div>
                        </div>

                        <div class="m-t-sm small">Espacio restante {{ ($restante * 100 * 1024) / 100 }} GB</div>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Mensajes</h5>
                    </div>
                    <div class="ibox-content" style="height: 120px;">
                        No disponible
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>In box</h5>
                    </div>

                    <div class="ibox-content">
                        <h5>Tabla con incidencias de los usuarios</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Blog</h5>
                    </div>

                    <div class="ibox-content">
                        <h5>Entrads del blog</h5>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-lg-6 pb-4">
                <div class="glassCard text-dark" style="height: 100%">
                    <h5 class="text-center">
                        {{ $customer->company }}
                    </h5>
                    <hr class="border-dark">

                    <div class="row px-5 pt-lg-5">
                        <div class="col-3 text-right">
                            <dt>Nif:</dt>
                        </div>
                        <div class="col-9 text-left">
                            <dd>{{ $customer->nif }}</dd>
                        </div>

                        <div class="col-3 text-right">
                            <dt>Dirección:</dt>
                        </div>
                        <div class="col-9 text-left">
                            <dd>{{ $customer->location }}</dd>
                        </div>

                        <div class="col-3 text-right">
                            <dt>Teléfono:</dt>
                        </div>
                        <div class="col-9 text-left">
                            <dd>{{ $customer->phone }}</dd>
                        </div>

                        <div class="col-3 text-right">
                            <dt>Email:</dt>
                        </div>
                        <div class="col-9 text-left">
                            <dd>{{ $customer->contact_mail }}</dd>
                        </div>

                        <div class="col-3 text-right">
                            <dt>Contacto:</dt>
                        </div>
                        <div class="col-9 text-left">
                            <dd>{{ $customer->contact }}</dd>
                        </div>


                    </div>

                </div>
            </div>

            <div class="col-lg-6">

                <div class="row">


                    <div class="col-lg-6 mb-4">
                        <div class="glassCard text-dark">
                            <h5 class="text-center">ODS pendientes</h5>
                            <h1 class="text-center">{{ $objectives_pending }}</h1>
                            <div class="text-right">
                                <strong class="text-navy">

                                    {{ count($objectives) }}
                                    {{ count($objectives) == 1 ? 'objetivo realizado' : 'objetivos realizados' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="glassCard text-dark">
                            <h5 class="text-center">Tareas pendientes</h5>
                            <h1 class="text-center">{{ count($tasks_pending) }}</h1>

                            <div class="text-right">
                                <strong class="text-navy">
                                    {{ count($tasks) - count($tasks_pending) }}
                                    {{ count($tasks) - count($tasks_pending) == 1 ? 'tarea realizada' : 'tareas realizadas' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="glassCard text-dark">
                            <h5 class="text-center">Centros</h5>
                            <h1 class="text-center">
                                {{ count($branches) }}
                            </h1>
                            <div class="text-right">
                                <strong class="{{ $trending > 0 ? 'text-navy' : 'text-danger' }} ">Tendencia
                                    {{ $trending }}%
                                    @if ($trending > 0)
                                        <i class="fa fa-level-up" aria-hidden="true"></i>
                                    @else
                                        <i class="fa fa-level-down" aria-hidden="true"></i>
                                    @endif
                                </strong>
                            </div>

                        </div>
                    </div>


                    <div class="col-lg-6 mb-4">
                        <div class="glassCard text-dark">
                            <h5 class="text-center">Usuarios en linea</h5>
                            <h1 class="text-center">{{ count($sessions) }}</h1>
                            <div class="text-right">
                                <strong class="text-danger">
                                    {{ count($users) - count($sessions) }}
                                    {{ count($users) - count($sessions) == 1 ? 'usuario desconectado' : 'usuarios desconectados' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 mb-lg-0 mb-4">
                <div style="height: 100%" class="glassCard text-dark p-0">
                    <map-branches branches="{{ json_encode($branches) }}"></map-branches>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="glassCard text-dark">
                    <h5 class="text-center">Evolución de las tareas</h5>

                    <evolutionTasks-chart user="{{ json_encode(auth()->user()) }}"></evolutionTasks-chart>
                </div>

            </div>


        </div>
    @endif
@endsection
