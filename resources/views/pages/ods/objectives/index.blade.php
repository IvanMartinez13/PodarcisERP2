@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.ods') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.targets') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li><a id="nav-dashboard" class="nav-link bg-transparent active" data-toggle="tab"
                    href="#dashboard">Dashboard</a></li>
            <li><a id="nav-objectives" class="nav-link bg-transparent" data-toggle="tab" href="#objective-tab">Objetivos</a></li>

            <li><a id="nav-documents" class="nav-link bg-transparent" data-toggle="tab" href="#documents-tab">Documentos</a></li>
        </ul>
        <div class="tab-content">

            <div role="tabpanel" id="dashboard" class="tab-pane active">
                <div class="panel-body bg-transparent">
                    <div class="animated fadeIn">
                        <dashboard-ods></dashboard-ods>
                    </div>
                </div>
            </div>

            <div role="tabpanel" id="objective-tab" class="tab-pane">
                <div class="panel-body bg-transparent">
                    <div class="animated fadeIn">

                        <div class="ibox animated fadeInRight">
                            <div class="ibox-title">
                                <h5 class="">{{ __('modules.targets') }}</h5>

                                @can('store Ods')
                                    <a href="{{ route('ods.objective.create') }}" class="btn btn-primary">
                                        {{ __('forms.create') }}
                                    </a>
                                @endcan

                                @can('delete Ods')
                                    <a href="{{ route('ods.objective.recover') }}" class="btn btn-secondary">
                                        {{ __('Recover') }}
                                    </a>
                                @endcan

                                <div class="ibox-tools">
                                    <a href="#" class="collapse-link">
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">
                                {{-- PANEL --}}
                                <div class="container-fluid table-responsive">
                                    <table id="objectives" class="table table-hover table-striped table-bordered js_datatable w-100">
                                        <thead>
                                            <tr>
                                                <th class="align-middle" style="15%">{{ __('columns.title') }}</th>
                                                <th class="align-middle" style="width: 20%">
                                                    {{ __('columns.description') }}
                                                </th>
                                                <th class="align-middle" style="width: 15%">
                                                    {{ __('columns.indicator') }}</th>
                                                <th class="align-middle" style="width: 10%">
                                                    {{ __('columns.increase') . ' | ' . __('columns.decrease') }}</th>
                                                <th class="align-middle" style="width: 10%">{{ __('columns.target') }}
                                                </th>
                                                <th class="align-middle" style="width: 12.5%">
                                                    {{ __('columns.base_year') }}</th>
                                                <th class="align-middle" style="width: 12.5%">
                                                    {{ __('columns.target_year') }}</th>
                                                <th class="align-middle" style="width: 5%">{{ __('columns.actions') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($objectives as $objective)
                                                <tr>
                                                    <td class="align-middle">{{ $objective->title }}</td>
                                                    <td class="align-middle">{!! $objective->description !!}</td>
                                                    <td class="align-middle">{{ $objective->indicator }}</td>
                                                    <td class="align-middle">
                                                        {{ $objective->increase == 0 ? __('columns.decrease') : __('columns.increase') }}
                                                    </td>
                                                    <td class="align-middle">{{ $objective->target }} %</td>
                                                    <td class="align-middle">{{ $objective->base_year }}</td>
                                                    <td class="align-middle">{{ $objective->target_year }}</td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group">

                                                            @can('update Ods')
                                                                <a href="{{ route('ods.objective.edit', $objective->token) }}"
                                                                    class="btn btn-link" title="Editar">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                            @endcan

                                                            @can('read Ods')
                                                                <a href="{{ route('ods.strategy.index', $objective->token) }}"
                                                                    class="btn btn-link" title="Estrategias">
                                                                    <i class="fas fa-clipboard-check"></i>
                                                                </a>
                                                            @endcan

                                                            @can('store Tareas')
                                                                <a href="{{ route('ods.objective.toTask', $objective->token) }}"
                                                                    class="btn btn-link">
                                                                    <i class="fa-solid fa-shuffle"></i>
                                                                </a>
                                                            @endcan

                                                            @can('delete Ods')
                                                                <a href="{{ route('ods.strategy.recover', $objective->token) }}"
                                                                    class="btn btn-link" title="Recuperar estrategias.">
                                                                    <i class="fa fa-recycle" aria-hidden="true"></i>
                                                                </a>

                                                                <button onclick="remove('{{ $objective->token }}')"
                                                                    class="btn btn-link" title="Eliminar">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="ibox-footer">
                                Podarcis SL. &copy; {{ date('Y') }}
                            </div>
                        </div>



                    </div>


                </div>
            </div>

            <div role="tabpanel" id="documents-tab" class="tab-pane">
                <div class="panel-body bg-transparent">
                    <div class="animated fadeIn">

                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Documentos</h5>

                                <div class="ibox-tools">
                                    <a href="#" class="collapse-link">
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="ibox-content">
                                <form action="{{ route('ods.addFiles') }}" method="POST"
                                    class="dropzone  mb-5" id="add-files">
                                    @csrf

                                    <div class="dz-message" style="height:200px;">
                                        {{ __('forms.files') }}
                                    </div>

                                    <div class="dropzone-previews"></div>

                                </form>
                                <div class="table-responsive">
                                    <table id="documents" class="table table-bordered table-striped table-hover js_datatable2 w-100">
                                        <thead>
                                            <tr>
                                                <th>{{__('columns.name')}}</th>
                                                <th>{{__('columns.actions')}}</th>
                                            </tr>
                                        </thead>
            
                                        <tbody id="files_list">
                                            @foreach ($ods_documents as $ods_document)
                                                <tr>
                                                    <td class="align-middle">{{$ods_document->name}}</th>
                                                        <td class="align-middle text-center">
                                                            <div class="btn-group">
                            
                                                                
                                                                <button class="btn btn-link" data-toggle="modal" data-target="#updateFile_{{$ods_document->token}}">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </button>
                            
                                                                <a class="btn btn-link" target="_BLANK" href="/storage/{{$ods_document->path}}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                                </a>
                            
                                                                {{--<button class="btn btn-link">
                                                                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                                                </button>--}}
                            
                                                                
                                                            </div>
                                                        </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="ibox-footer">
                                Podarcis SL. &copy; {{date('Y')}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>


    @foreach ($objectives as $objective)
        <form action="{{ route('ods.objective.delete') }}" id="delete_{{ $objective->token }}" method="POST">
            @csrf
            @method('put')
            <input name="token" type="hidden" value="{{ $objective->token }}">
        </form>
    @endforeach


    @foreach ($ods_documents as $ods_document)
        <div class="modal fade" id="updateFile_{{$ods_document->token}}" tabindex="-1" aria-labelledby="updateFile_{{$ods_document->token}}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-primary">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFile_{{$ods_document->token}}Label">{{ __('forms.update') }} {{ __('modules.files') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/ods/updateFile" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <input name="token" type="hidden" value="{{$ods_document->token}}">
                        <div class="modal-body bg-white text-dark">
                            <div class="form-group">
                            <label for="name_{{$ods_document->token}}">{{ __('forms.name') }}:</label>
                            <input type="text" name="name" id="name_{{$ods_document->token}}" class="form-control" placeholder="{{ __('forms.name') }}..." value="{{$ods_document->name}}">
                            </div>

                            <div class="form-group">
                                <label for="file{{$ods_document->token}}">{{ __('forms.fileLabel') }}:</label>
                                <div class="custom-file">
                                    <input id="file{{$ods_document->token}}" name="file" type="file" class="custom-file-input">
                                    <label for="file{{$ods_document->token}}" class="custom-file-label">{{ __('forms.file') }}</label>
                                </div> 
                            </div>

                        </div>

                        <div class="modal-footer bg-white text-dark">
                    
                            <button type="submit" class="btn btn-primary">{{ __('forms.update') }}</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('forms.close') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    @endforeach
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

    <script>
        function remove(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this objective!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarlo",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }

        //SAVE SELECTED TAB

        $('#nav-dashboard').on('click', () => {
            localStorage.setItem('objectivesTab', 'nav-dashboard');
        });

        $('#nav-objectives').on('click', () => {
            localStorage.setItem('objectivesTab', 'nav-objectives');
        });

        $('#nav-documents').on('click', () => {
            localStorage.setItem('objectivesTab', 'nav-documents');
        });

        if (localStorage.getItem('objectivesTab') == "nav-dashboard") {

            $('#nav-dashboard').tab('show') // Select tab
        } else if (localStorage.getItem('objectivesTab') == "nav-objectives") {

            $('#nav-objectives').tab('show') // Select tab
        }else if (localStorage.getItem('objectivesTab') == "nav-documents") {

            $('#nav-documents').tab('show') // Select tab
        }

        $(document).ready(function () {
            $(".js_datatable2 thead tr")
                .clone(true)
                .addClass("filters2")
                .appendTo(".js_datatable2 thead");

            $(".js_datatable2").DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    "colvis",
                    { extend: "copy" },
                    { extend: "csv" },
                    { extend: "excel", title: "ExampleFile" },
                    { extend: "pdf", title: "ExampleFile" },

                    {
                        extend: "print",
                        customize: function (win) {
                            $(win.document.body).addClass("white-bg");
                            $(win.document.body).css("font-size", "10px");

                            $(win.document.body)
                                .find("table")
                                .addClass("compact")
                                .css("font-size", "inherit");
                        },
                    },
                ],
                language: {
                    url: "/js/plugins/datatables/es.json",
                },

                stateSave: true,
                colReorder: true,
                orderCellsTop: true,
                fixedHeader: true,

                initComplete: function () {
                    var api = this.api();

                    // For each column
                    api.columns()
                        .eq(0)
                        .each(function (colIdx) {
                            // Set the header cell to contain the input element
                            var cell = $(".filters2 th").eq(
                                $(api.column(colIdx).header()).index()
                            );
                            var title = $(cell).text();
                            if (title != "Acciones") {
                                title = title.replace(
                                    /                                                    /g,
                                    ""
                                );

                                $(cell).html(
                                    '<input type="text" class="form-control " placeholder="' +
                                        title +
                                        '" />'
                                );
                            } else {
                                $(cell).html("");
                            }

                            // On every keypress in this input
                            $(
                                "input",
                                $(".filters2 th").eq(
                                    $(api.column(colIdx).header()).index()
                                )
                            )
                                .off("keyup change")
                                .on("keyup change", function (e) {
                                    e.stopPropagation();

                                    // Get the search value
                                    $(this).attr("title", $(this).val());
                                    var regexr = "({search})"; //$(this).parents('th').find('select').val();

                                    var cursorPosition = this.selectionStart;
                                    // Search the column for that value
                                    api.column(colIdx)
                                        .search(
                                            this.value != ""
                                                ? regexr.replace(
                                                    "{search}",
                                                    "(((" + this.value + ")))"
                                                )
                                                : "",
                                            this.value != "",
                                            this.value == ""
                                        )
                                        .draw();

                                    $(this)
                                        .focus()[0]
                                        .setSelectionRange(
                                            cursorPosition,
                                            cursorPosition
                                        );
                                });
                        });
                },
            });
        });

        //ADD ROWS TO DOCUMENTS BODY
        Dropzone.options.addFiles = {
            autoProcessQueue: true,
            uploadMultiple: true,
            maxFilezise: 10,
            maxFiles: 100,

            init: function() {

                myDropzone = this;

                this.on("addedfile", function(file) {
                    console.log(file)

                    var data = new FileReader;
                    data.readAsDataURL(file);

                    $(data).on("load", function(event) {

                        var path = event.target.result;

                        $("#imgUser").attr("src", path);

                    })
                });

                this.on("complete", function(file) {
                    myDropzone.removeFile(file);

                });

                this.on("successmultiple", (file, response) => {
                    toastr.success(response.message)
                    myDropzone.processQueue.bind(myDropzone)
                    //ADD ROW TO TABLE
                    response.ods_files.map((ods_file) => {
                        $('#files_list').append(
                            `<tr>
                            <td class="align-middle">
                                ${ods_file.name}
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group">

                                    
                                    <button class="btn btn-link" data-toggle="modal" data-target="#updateFile_${ods_file.token}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button>

                                    <a class="btn btn-link" target="_BLANK" href="/storage/${ods_file.path}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    
                                </div>
                            </td>
                         </tr>`
                        );

                        $('body').append(
                            `
                            <div class="modal fade" id="updateFile_${ods_file.token}" tabindex="-1" aria-labelledby="updateFile_${ods_file.token}Label" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content bg-primary">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateFile_${ods_file.token}Label">{{ __('forms.update') }} {{ __('modules.files') }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/ods/updateFile" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')

                                        <input name="token" type="hidden" value="${ods_file.token}">
                                        <div class="modal-body bg-white text-dark">
                                            <div class="form-group">
                                            <label for="name_${ods_file.token}">{{ __('forms.name') }}:</label>
                                            <input type="text" name="name" id="name_${ods_file.token}" class="form-control" placeholder="{{ __('forms.name') }}..." value="${ods_file.name}">
                                            </div>
                        
                                            <div class="form-group">
                                                <label for="name_${ods_file.token}">{{ __('forms.fileLabel') }}:</label>
                                                <div class="custom-file">
                                                    <input id="file${ods_file.token}" name="file" type="file" class="custom-file-input">
                                                    <label for="file${ods_file.token}" class="custom-file-label">{{ __('forms.file') }}</label>
                                                </div> 
                                            </div>
                        
                                        </div>

                                        <div class="modal-footer bg-white text-dark">
                                    
                                            <button type="submit" class="btn btn-primary">{{ __('forms.update') }}</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('forms.close') }}</button>
                                        </div>
                                    </form>


                                </div>
                                </div>
                            </div>
                        `
                        );
                    })


                });
            }
        }

    </script>
@endpush
