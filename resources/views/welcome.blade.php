<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


    <!-- PLUGGINS -->
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/landing.css" rel="stylesheet">

</head>

<body class="bg-white">



    <header class="header">
        {{-- NAVBAR LANDING --}}
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-dark bg-primary nav-init">
            <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
            <button style="border: none" class="navbar-toggler border-none btn btn-primary" type="button"
                data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>


                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif --}}
                        @endauth
                    @endif
                </ul>


            </div>
        </nav>
        {{-- END NAVBAR LANDING --}}
        <div id="carousel" class="carousel slide " data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ url('/') }}/img/landing/header_one.jpg" class="d-block mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">

                            <p>
                                El programa de gestión que tiene todo lo que necesitas… donde
                                quieras y cuando quieras.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ url('/') }}/img/landing/header_two.png" class="d-block  mx-auto" alt="...">
                    <div class="carousel-caption">
                        <div class="text-header wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.5s">

                            <p>
                                Libera tu potencial de crecimiento con {{ env('APP_NAME') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>


    <main>

        <div class="container-fluid py-5">
            <div class="container">
                <div class="row">


                    <div class="col-md-7 wow fadeInLeft" data-wow-duration="2s" data-wow-delay="0.5s">
                        <img class="img-fluid zoom" src="{{ url('/') }}/img/landing/perspective.png" alt="">
                    </div>

                    <div class="col-md-5 wow fadeInRight" data-wow-duration="2s" data-wow-delay="0.5s">
                        <h3 class="mt-5">
                            <i class="fas fa-stopwatch"></i> Rápido
                        </h3>
                        <p>
                            Accede a toda la información de manera rápida y sencilla. Con nuestro <b>dashboard
                                reactivo</b>
                            olvidate de las pantallas de cargado.
                        </p>

                        <h3 class="mt-5">
                            <i class="fas fa-mobile-alt"></i> Accesible
                        </h3>
                        <p>
                            ¿Móvil, tablet o pc? No importa <b>{{ env('APP_NAME') }}</b> se ajusta a tu dispositivo.
                            Donde sea como sea y cuando sea ¡No hay limites!
                        </p>

                        <h3 class="mt-5">
                            <i class="fa-solid fa-face-grin-wink"></i> Amigable
                        </h3>
                        <p>
                            Contamos con un panel de gestión y una interfaz de usuario muy intuitiva y amigable. De esta
                            manera podrás ser el <b>doble de eficaz en la mitad de tiempo.</b>
                        </p>
                    </div>

                </div>
            </div>

        </div>

        {{-- CARACTERISTICAS --}}
        <div class="container-fluid text-center py-5 caracteristics">

            <div class="caracteristics-content">
                <h1 class="wow fadeInUp " data-wow-duration="2s" data-wow-delay="0.5s">
                    Una <b>aplicación</b> para cada necesidad
                </h1>

                <div class="cards-container pt-5">
                    <div class="row  mt-5">
                        <div class="col-lg-4 mb-5">

                            <div class="glassCard text-dark">

                                <div class="marco">
                                    <img src="{{ url('/') }}/img/landing/charts.jpg" />
                                </div>
                                <hr class="border-dark" />

                                <h3>
                                    <dt>Proyectos</dt>
                                </h3>
                                <p class="text-left">
                                    Una solución <b>sencilla</b> a los <b>proyectos</b> más complejos.
                                    Con
                                    <b>Podarcis ERP</b> podrás observar el avance de tus proyectos en tiempo real.

                                </p>

                                <ul class="text-left">
                                    <li>Registros de comunicaciones.</li>
                                    <li>Repositorios de documentos.</li>
                                    <li>Indicadores.</li>
                                </ul>

                                <p class="text-left">
                                    Podrás tener un control total en el avance de tus proyectos.
                                </p>

                            </div>

                        </div>

                        <div class="col-lg-4 mb-5">

                            <div class="glassCard text-dark">
                                <div class="marco">
                                    <img src="{{ url('/') }}/img/landing/ods.png" />
                                </div>
                                <hr class="border-dark" />

                                <h3>
                                    <dt>Objetivos de desarrollo sostenible</dt>
                                </h3>

                                <p class="text-left">
                                    Los Objetivos de Desarrollo Sostenible son 17 objetivos y 169 metas propuestos como
                                    continuación de los ODM (Objetivos de Desarrollo del Milenio) incluyendo nuevas
                                    esferas
                                    como el cambio climático, la
                                    desigualdad económica, la innovación, el consumo sostenible, la paz y la justicia,
                                    entre
                                    otras prioridades.
                                </p>

                                <p class="text-left">
                                    Con <b>Podarcis ERP</b> podrás definir cada uno de tus objetivos y asociarlos a un
                                    ODS.
                                    Controla el grado de cumplimiento de cada uno de tus objetivos y estrategias.
                                </p>
                            </div>

                        </div>

                        <div class="col-lg-4 mb-5">

                            <div class="glassCard text-dark">
                                <div class="marco">
                                    <img src="{{ url('/') }}/img/landing/equipo.jpg" />
                                </div>
                                <hr class="border-dark" />

                                <h3>
                                    <dt>Equipos de trabajo</dt>
                                </h3>

                                <p class="text-left">
                                    Controla quien puede acceder a tus proyectos. <b>Podarcis ERP</b> te permite
                                    personalizar
                                    al máximo tu equipo de
                                    trabajo.
                                </p>
                                <p class="text-left">
                                    Define los permisos y los roles de cada uno de tus colaboradores. Coordina <b>quién,
                                        cuándo
                                        y cómo</b> gestionar cada una de las tareas.
                                </p>



                                <p class="text-left">
                                    En la unión está la fuerza.
                                </p>


                            </div>

                        </div>


                    </div>
                </div>


            </div>

            <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>





        {{-- <div class=" bg-charts">
            <div class="bg-transparentDark">
                <div class="to-right">

                    <div class="glassCard">
                        <h3 class="text-center">
                            Toda la información a tu alcance.
                        </h3>

                        <hr class="border-white">

                        Con nuestro dashboard podrás observar de una manera rápida y detallada.
                    </div>

                </div>
            </div>



        </div>


        
        <div class="container-fluid bg-primary">

            <div class="mx-lg-5 py-5 bg-light text-dark">
                <h1 class="text-center">Un problema, una app</h1>

                <p class="text-center">AQUI MOSTRARIAMOS LOS MÓDULOS DE LA APP</p>
            </div>

        </div> --}}

    </main>



    <footer>

        <div class="part-1">

            <div class="my-auto">
                Mantente conectado con nostros en las redes sociales:
            </div>

            <div class="ml-md-auto button-container">
                <button class="linkedin social-button">
                    <i class="fa-brands fa-linkedin-in"></i>
                </button>
                <button class="instagram social-button">
                    <i class="fa-brands fa-instagram"></i>
                </button>
                <button class="facebook social-button">
                    <i class="fa-brands fa-facebook-f"></i>
                </button>
                <button class="twitter social-button">
                    <i class="fa-brands fa-twitter"></i>
                </button>
            </div>
        </div>

        <div class="part-2 px-5">
            <div class="row py-3">

                <div class="col-lg-4 mb-lg-0 mb-3 pr-5">
                    <h2>{{ env('APP_NAME') }}</h2>
                    <hr class="border-white">
                    <p class="text-justify">
                        El mejor software de gestión que tiene todo lo que necesitas.
                        Desarrollado por Podarcis SL. Somos su consultoría de referencia. Si necesita ayuda para
                        optimizar sus procesos organizativos, de calidad, gestión empresarial, o precisa de una
                        tramitación ambiental para poder seguir desarrollando su negocio, no dude en contactar con
                        nosotros.
                    </p>

                    <a class="foot-link" href="https://www.podarcis.com/" target="_BLANK">Leer más...</a>
                </div>

                <div class="col-lg-4 mb-lg-0 mb-3 px-5">
                    {{-- <h2>Otros productos</h2>

                    <p>
                        <a class="foot-link" href="https://legislaciononline.es/" target="_BLANK">Legislación
                            online</a>
                    </p>



                    <p>
                        <a class="foot-link" href="https://calculatuhuelladecarbono.com/" target="_BLANK">Calcula
                            tu huella de
                            carbono</a>
                    </p>

                    <p>
                        <a class="foot-link" href="https://www.vigilanciaambiental.com/" target="_BLANK">Vigilancia
                            ambiental</a>
                    </p>



                    <p>
                        <a class="foot-link" href="https://www.uuupsapp.com/" target="_BLANK">Uuupsap | Gestión
                            de incidencias</a>
                    </p> --}}


                </div>

                <div class="col-lg-4 mb-lg-0 mb-3 pr-5">
                    <h2>Otros productos</h2>
                    <hr class="border-white">
                    <p>
                        <a class="foot-link" href="https://legislaciononline.es/" target="_BLANK">Legislación
                            online</a>
                    </p>



                    <p>
                        <a class="foot-link" href="https://calculatuhuelladecarbono.com/" target="_BLANK">Calcula
                            tu huella de
                            carbono</a>
                    </p>

                    <p>
                        <a class="foot-link" href="https://www.vigilanciaambiental.com/" target="_BLANK">Vigilancia
                            ambiental</a>
                    </p>



                    <p>
                        <a class="foot-link" href="https://www.uuupsapp.com/" target="_BLANK">Uuupsap | Gestión
                            de incidencias</a>
                    </p>

                </div>


            </div>

        </div>

        <div class="part-3">

            <div class="float-right">
                Todos los derechos reservados.
            </div>

            <div>
                <strong>Copyright</strong> Podarcis SL. &copy; {{ date('Y') }}
            </div>

        </div>







    </footer>

    <!-- Mainly scripts -->
    <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/') }}/js/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/wow/wow.min.js"></script>
    <script>
        new WOW().init();
        document.addEventListener("DOMContentLoaded", function() {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 500) {
                    document.getElementById('navbar_top').classList.remove('nav-init');
                    document.getElementById('navbar_top').classList.add('fixed-top');
                    document.getElementById('navbar_top').classList.add('animated-fast');
                    document.getElementById('navbar_top').classList.add('slideInDown');
                    document.getElementById('navbar_top').classList.add('bg-primary');

                    // add padding top to show content behind navbar
                    navbar_height = document.querySelector('.navbar').offsetHeight;
                    document.body.style.paddingTop = navbar_height + 'px';
                } else {
                    document.getElementById('navbar_top').classList.remove('fixed-top');
                    document.getElementById('navbar_top').classList.remove('animated-fast');
                    document.getElementById('navbar_top').classList.remove('slideInDown');
                    document.getElementById('navbar_top').classList.add('nav-init');
                    // remove padding top from body
                    document.body.style.paddingTop = '0';
                }
            });
        });
    </script>

</body>

</html>
