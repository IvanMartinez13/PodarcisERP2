<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


    <!-- PLUGGINS -->
    <link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/fontawesome/css/all.min.css" rel="stylesheet">

    <link href="{{ url('/') }}/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/datatables/datatables.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/leaflet/leaflet.css" rel="stylesheet">
    <link src="{{ url('/') }}/js/plugins/leaflet/groupLayerControl/dist/leaflet.groupedlayercontrol.min.css"
        rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/select2/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href='{{ url('/') }}/js/plugins/leaflet/fullscreen/dist/leaflet.fullscreen.css' rel='stylesheet' />

    <!-- Styles -->
    <link href="{{ url('/') }}/css/animate.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/style.css" rel="stylesheet">

    @stack('styles')


</head>

<body class="{{ (session()->get('skin') == null)? 'md-skin' : session()->get('skin')}}">

    <div id="wrapper">

        {{-- SIDEBAR --}}
        @include('shared.sidebar')

        <div id="page-wrapper">
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

            {{-- TOPNAV --}}
            @include('shared.topnav')

            {{-- CONTENT --}}
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-left">

                            @yield('content')
                            
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            @include('shared.footer')

            <form id="logout_form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>

        </div>
    </div>


    {{-- MODAL CONFIG THEME --}}
    <div class="modal fade" id="configThemeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog" role="document">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">{{__('Config theme')}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-white">
                <a href="{{route('dashboard.changeSkin', 'md-skin')}}" class="btn btn-block" style="background-color: #1abc9c; color:white">
                    Material design
                </a>
                
                <a href="{{route('dashboard.changeSkin', 'skin-1')}}" class="btn btn-block btn-bluelight">
                    Blue light
                </a>

                <a href="{{route('dashboard.changeSkin', 'skin-2')}}" class="btn btn-block btn-darkblue">
                    Dark blue
                </a>

                <a href="{{route('dashboard.changeSkin', 'skin-3')}}" class="btn btn-block btn-orange">
                    Purple orange
                </a>

                <a href="{{route('dashboard.changeSkin', 'basic')}}" class="btn btn-block border btn-secondary">
                    Basic skin
                </a>

                <a href="{{route('dashboard.changeSkin', 'dark-skin')}}" class="btn btn-block btn-dark">
                    Dark skin
                </a>

                <a href="{{route('dashboard.changeSkin', 'light-skin')}}" class="btn btn-block border btn-light">
                    Light skin
                </a>




            </div>
            <div class="modal-footer bg-white">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Mainly scripts -->
    <script src="{{ url('/') }}/js/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/') }}/js/popper.min.js"></script>
    <script src="{{ url('/') }}/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="{{ url('/') }}/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ url('/') }}/js/inspinia.js"></script>
    <script src="{{ url('/') }}/js/plugins/pace/pace.min.js"></script>

    <!-- Scripts -->
    <script src="{{ url('/') }}/js/plugins/datatables/datatables.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/datatables/fixedHeader.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/datatables/colreorder.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/switchery/switchery.js"></script>
    <script src="{{ url('/') }}/js/plugins/bs-custom-file/bs-custom-file-input.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/leaflet.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/groupLayerControl/dist/leaflet.groupedlayercontrol.min.js">
    </script>
    <script src="{{ url('/') }}/js/plugins/toastr/toastr.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/select2/select2.full.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/summernote/summernote-bs4.js"></script>
    <script src="{{ url('/') }}/js/plugins/dropzone/dropzone.js"></script>
    <script src="{{ url('/') }}/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/iCheck/icheck.min.js"></script>
    <script src="{{ url('/') }}/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"
        integrity="sha512-xQBQYt9UcgblF6aCMrwU1NkVA7HCXaSN2oq0so80KO+y68M+n64FOcqgav4igHe6D5ObBLIf68DWv+gfBowczg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/leaflet-kmz@latest/dist/leaflet-kmz.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/shapes/shp.js"></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/shapes/leaflet.shpfile.js"></script>
    <script src='{{ url('/') }}/js/plugins/leaflet/fullscreen/dist/Leaflet.fullscreen.min.js'></script>
    <script src="{{ url('/') }}/js/plugins/leaflet/wms/dist/leaflet.wms.js"></script>
    <script src="{{ url('/') }}/js/plugins/chartJs/Chart.min.js"></script>


    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>


    <script src="{{ url('/') }}/js/app.js" defer></script>
    @stack('scripts')

    <script>

        
        $(document).ready(() => {
            var switches = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

            switches.forEach(function(input) {
                var switchery = new Switchery(input, {
                    color: '#1ab394',
                    jackColor: '#f3f3f4'
                });
            });
            
        })

        setTimeout(() => {
            if (localStorage.getItem('navbarCollapsed') > 0) {
            
            $("body").removeClass('mini-navbar')

            }else{

                $("body").addClass('mini-navbar');
            }
        }, 800);

        function toggleNav(){
            
            let value = localStorage.getItem('navbarCollapsed');

            if (localStorage.getItem('navbarCollapsed') > 0) {

                localStorage.setItem('navbarCollapsed', 0);
            }else{
                localStorage.setItem('navbarCollapsed', 1);
            }

            
        }


    </script>

    @if (\Request::route()->getName() != "teams.team")
        <script>

            var user = Number.parseInt("{{auth()->user()->id}}");

            var notifications = [];

            setInterval(() => {
                
                checkNotifications(user)
            }, 500);
            //CHECK NOTIFICATIONS

            function checkNotifications(user){

                var formData  = new FormData();

                formData.append("user", user);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    url: "{{url('/')}}/get_notifications",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",

                    success: function(response) {
                        
                        if (notifications.length != response.notifications.length) {
                            notifications = response.notifications;

                            //NOTIFICATE
                            $('#notifications_teams').removeClass('d-none');
                            $('#notifications_teams').text(notifications.length);

                            var notificate = false;

                            notifications.map( notification => {
                                if (notification.notified == 0) {
                                    notificate = true;
                                }
                            } );

                            if (notificate) {
                                if (notifications.length == 1) {
                                    toastr.info(`Tienes ${notifications.length} mensaje sin leer.`);
                                    //sonido

                                    if (!audio) {
                                        var audio = new Audio('{{url("/")}}/audio/notification.mp3');
                                    }
                                    audio.play();

                                }else{
                                    toastr.info(`Tienes ${notifications.length} mensajes sin leer.`);
                                    //sonido
                                    if (!audio) {
                                        var audio = new Audio('{{url("/")}}/audio/notification.mp3');
                                    }
                                    
                                    audio.play();
                                }
                            }

                            var teams = response.teams;

                            var notifications_by_teams = [];
                            
                            teams.map( team => {
                                
                                notifications_by_teams[team.token] = 0;
                                notifications.map( notification => {
                                    
                                    if (notification.message.team.token == team.token){

                                        notifications_by_teams[team.token]++;

                                        
                                    }
                                } )
                            } );

                            teams.map( team => {
                                $('#notifications_'+team.token).removeClass('d-none');
                                $('#notifications_'+team.token).text(notifications_by_teams[team.token]);
                            });
                            
                            
                            
                        }
                    }
                
                })
            }


            
        </script>
    @endif

</body>

</html>
