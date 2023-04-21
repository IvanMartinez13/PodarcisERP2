@extends ("layouts.app")

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.sga') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.sga') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>
    {{-- LOGO CLIENTE --}}


    <div class="row">
        <div class="col-lg-5 h-100">
            @if ($manager)
                <img src="{{ url('/storage') . $manager->profile_photo }}" alt="logotipo cliente"
                    style="width: 60%; max-height: 100px;" class="rounded mb-3" style="">
            @endif
            <div class="containerMenu d-none d-lg-block">
                <div id="navMenu" class="diamond d-flex">
                    <div id="mainRotCorrect" class="rotCorrect text-center">
                        <i class="fa fa-cubes fa-4x" aria-hidden="true"></i>
                        <h2 class="text-white">{{ __('modules.sga') }}</h2>
                    </div>
                </div>
                <div id="nav1" class="navegate small nav1 diamond ">
                    <div class="rotCorrect my-auto mx-auto text-center">

                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><br>
                        <small class="text-white">Análisis de contexto</small>
                    </div>
                </div>

                <div id="nav2" class="navegate small nav2 diamond">
                    <div class="rotCorrect my-auto mx-auto text-center">

                        <i class="fa-regular fa-clipboard" aria-hidden="true"></i><br>
                        <small class="text-white">Plan de acción</small>
                    </div>
                </div>
                <div id="nav3" class="navegate small nav3 diamond">
                    <div class="rotCorrect my-auto mx-auto text-center">

                        <i class="fa-brands fa-uncharted" aria-hidden="true"></i><br>
                        <small class="text-white">Operativa</small>
                    </div>
                </div>
                <div id="nav4" class="navegate small nav4 diamond">
                    <div class="rotCorrect my-auto mx-auto text-center">

                        <i class="fa-solid fa-chart-column" aria-hidden="true"></i><br>
                        <small class="text-white">Análisis desempeño</small>
                    </div>
                </div>
                <div id="nav5" class="navegate small nav5 diamond">
                    <div class="rotCorrect my-auto mx-auto text-center">

                        <i class="fa-solid fa-arrow-rotate-right" aria-hidden="true"></i><br>
                        <small class="text-white">Gestión del cambio</small>
                    </div>
                </div>
            </div>
        </div>
        {{-- BOMBILLAS, en funcion de si el proceso se ha realizado, esta en curso o NO se ha realizado --}}
        <div class="col-lg-6 offset-lg-1">
            {{-- box 1 --}}
            <div class="ibox">
                <div class="ibox-title bg-cian">
                    <h5>
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        Procesos Estratégicos
                    </h5>
                    <div class="ibox-tools text-dark">
                        <a href="{{ route('sga.create_process', $estrategicos) }}"
                            class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Crear</span>
                        </a>

                        <a href="" class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Importar</span>
                        </a>

                        <a href="" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>
                <div class="ibox-content">

                    @foreach ($estrategicosProcesos as $proceso)
                        <div class="row">
                            <div class="col-9">
                                <a href="https://www.podarcis.com" class="btn btn-link"
                                    target="_blank">{{ $proceso->name }}</a>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fas fa-lightbulb text-danger"></i>
                            </div>
                        </div>
                        @if (count($estrategicosProcesos) > 1)
                            <hr>
                        @endif
                    @endforeach



                </div>
            </div>
            {{-- box 2 --}}
            <div class="ibox">
                <div class="ibox-title bg-darkBlue">
                    <h5>
                        <i class="fa-brands fa-uncharted" aria-hidden="true"></i> Procesos Operativos
                    </h5>
                    <div class="ibox-tools text-dark">
                        <a href="{{ route('sga.create_process', $operativos) }}"
                            class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Crear</span>
                        </a>

                        <a href="" class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Importar</span>
                        </a>

                        <a href="" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    @foreach ($operativosProcesos as $proceso)
                        <div class="row">
                            <div class="col-9">
                                <a href="https://www.podarcis.com" class="btn btn-link"
                                    target="_blank">{{ $proceso->name }}</a>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fas fa-lightbulb text-danger"></i>
                            </div>
                        </div>
                        @if (count($operativosProcesos) > 1)
                            <hr>
                        @endif
                    @endforeach

                </div>

            </div>

            {{-- box 3 --}}
            <div class="ibox">
                <div class="ibox-title bg-secondary">
                    <h5 class="text-white">
                        <i class="fa-solid fa-chart-column"></i>
                        Procesos de Soporte
                    </h5>
                    <div class="ibox-tools text-dark">
                        <a href="{{ route('sga.create_process', $soporte) }}"
                            class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Crear</span>
                        </a>

                        <a href="" class="btn btn-xs btn-light text-dark my-auto">
                            <span class="text-dark">Importar</span>
                        </a>

                        <a href="" class="collapse-link">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content">

                    @foreach ($soporteProcesos as $proceso)
                        <div class="row">
                            <div class="col-9">
                                <a href="https://www.podarcis.com" class="btn btn-link"
                                    target="_blank">{{ $proceso->name }}</a>
                            </div>
                            <div class="col-3 text-right">
                                <i class="fas fa-lightbulb text-danger"></i>
                            </div>
                        </div>
                        @if (count($soporteProcesos) > 1)
                            <hr>
                        @endif
                    @endforeach
                </div>

            </div>


        </div>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        .bg-cian {
            background: #006980 !important;
            color: white !important;
        }

        .bg-darkBlue {
            background: #1c3355 !important;
            color: white !important;
        }




        .containerMenu {
            width: 100%;
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        /* fat rhomb */
        #navMenu {
            top: 180px;
            left: 200px;
            width: 160px;
            height: 160px;
            z-index: 100;
            background: linear-gradient(90deg, #1ab394, #57b8a4, #1ab394);
            -webkit-background: linear-gradient(90deg, #1ab394, #57b8a4, #1ab394);
            background-size: 400% 400%;
            -webkit-background-size: 400% 400%;
            animation: gradient 5s infinite;
            -webkit-animation: gradient 5s infinite;
        }

        #navMenu:hover,
        .navegate:hover {
            background: #179d82;
        }

        @keyframes gradient {
            50% {
                background-position: 100% 0;
            }
        }

        @-webkit-keyframes gradient {
            50% {
                background-position: 100% 0;
            }
        }


        .diamond {

            position: absolute;
            width: 77.5px;
            height: 77.5px;
            transform: rotate(45deg);
            -webkit-transform: rotate(45deg);
            background: #1ab394;
            margin: 100px;
            cursor: pointer;
            box-shadow: 1px 4px 10px #101010;
        }

        .diamond:active {
            background: #179d82;
            box-shadow: 0px 1px 2.5px #101010;
            transition: 0.1s;
            -webkit-transition: 0.1s;
        }

        /*.popUp */
        /* mini rhombs */

        /* ok */
        .nav1 {
            /* antes 86-> restar para subir */
            top: 75px;
            /* antes 287-> restar para desplazar izquierda */
            left: 302px;
            display: flex;
            transition: 0.5s !important;
            -webkit-transition: 0.5s !important;

        }

        /* ok */
        .nav2 {
            /* antes 146 */
            top: 150px;
            /* antes 347 */
            left: 378px;
            display: flex;
            transition: 1s !important;
            -webkit-transition: 1s !important;

        }

        /* ok */
        .nav3 {

            /* antes 196 */
            top: 222px;
            /* antes 397 */
            left: 450px;
            display: flex;
            transition: 1.5s !important;
            -webkit-transition: 1.5s !important;

        }

        /* ok */
        .nav4 {

            /* antes 266 */
            top: 296px;
            /* antes 347 */
            left: 380px;
            display: flex;
            transition: 2s !important;
            -webkit-transition: 2s !important;

        }

        /* ok */
        .nav5 {

            /* antes 316  restar para subir */
            top: 375px;
            /* antes 287 restar para desplazar izquierda */
            left: 305px;
            display: flex;
            transition: 2.5s !important;
            -webkit-transition: 2.5s !important;

        }

        .small {
            top: 196px;
            left: 246px;
            z-index: 10;
            background: #1ab394;

        }

        .rotCorrect {
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            margin: auto;
        }

        #mainRotCorrect {
            margin: auto;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);

        }

        #navMenu i,
        .navegate i {
            color: #EEEEEE;
        }
    </style>
@endpush

@push('scripts')
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

    <script>
        $(document).ready(function() {

            setTimeout(() => {
                if ($(".navegate").hasClass("small")) {
                    $(".navegate").removeClass("small");
                } else {
                    $(".navegate").addClass("small");
                }
            }, 500);

            $("#navMenu").click(function() {
                //$(".nav").toggleClass("small");
                if ($(".navegate").hasClass("small")) {
                    $(".navegate").removeClass("small");
                } else {
                    $(".navegate").addClass("small");
                }
            });
        });
    </script>
@endpush
