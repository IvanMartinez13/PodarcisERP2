@extends('layouts.app')

@section('content')
    @if (auth()->user()->hasRole('super-admin'))
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
               <div class="glassCard text-dark h-100">
                    <div class="text-center">
                        <h1>Clientes</h1>
                        <h1>{{count($customers)}}</h1>
                    </div>
                   
               </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glassCard text-dark h-100">
                    
                    <div class="text-center">
                        <h1>Módulos</h1>
                        <h1>{{count($modules)}}</h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glassCard text-dark h-100">
                    
                    <div class="text-center">
                        <h1>Espacio en disco</h1>
                        <p class="h6">{{ $size }} usados.</p>
                    </div>
                   
                    <div class="progress progress-mini">
                        <div style="width: {{ ( (100 - ($restante * 100)) > 1 )? (100 - ($restante * 100)) : 1}}%;" class="progress-bar"></div>
                    </div>

                    <div class="m-t-sm small">Espacio restante {{ ($restante * 100 * 1024) / 100 }} GB</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="glassCard text-dark h-100">
                    
                    <div class="text-center">
                        <h1>Mensajes</h1>
                        <h1>No disponible.</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="glassCard text-dark h-100">
                    
                    <div class="text-left">
                        <h2>In box</h2>
                        <h2>No disponible.</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="glassCard text-dark h-100">
                    
                    <div class="text-left">
                        <h2>Blog</h2>
                        @foreach ($blogs as $key => $blog)
                            @if ($key < 4)
                            <div class="row">
                                
                                    <div class="col-4">
                                        <a class="link-blog" href="{{route('blog.preview', $blog->token)}}">
                                            @if ($blog->image)
                                                <div class="blog-marco">
                                                    <img src="{{url('/').'/storage'.$blog->image}}" class="img-fluid" />
                                                </div>
                                                
                                            @else
                                                No tiene imagen.
                                            @endif
                                        </a>
                                    </div>

                                    <div class="col-8 text-left my-auto">

                                        <a class="link-blog" href="{{route('blog.preview', $blog->token)}}">
                                            <div>
                                                <h4>{{$blog->title}}</h4>

                                                {!!substr($blog->content, 0, 150);!!}...
                                            </div>
                                        </a>

                                            
                                        
                                    </div>
                                

                            </div>
                                
                            @endif
                        @endforeach

                        <a href="{{route('blog.index')}}" class="btn btn-primary mt-3">
                            Ver más...
                        </a>
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
