@extends('layouts.app')

@section('content')

    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.blog') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>{{ __('modules.blog') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('dashboard') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('modules.blog')}}</h5>

            <a href="{{route('blog.create') }}" class="btn btn-primary">
                {{__('forms.create') }}
            </a>

            <div class="ibox-tools">
                <a class="collapse-link" href="#">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped js_datatable">
                    <thead>
                        <tr>
                            <th class="w-25">{{__('columns.title') }}</th>
                            <th class="w-25">{{__('columns.image') }}</th>
                            <th class="w-25">{{__('columns.is_active') }}</th>
                            <th class="w-25">{{__('columns.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($blogs as $blog)
                            <tr>
                                <td class="align-middle">{{$blog->title}}</td>
                                <td class="align-middle">
                                    @if ($blog->image)
                                        <img src="{{url('/').'/storage'.$blog->image}}" class="img-fluid" />
                                    @else
                                        No tiene imagen.
                                    @endif
                                </td>
                                <td class="text-center align-middle">

                                    @if ($blog->is_active == 1)

                                        <input onchange="changeState('{{$blog->token}}')" type="checkbox" class="js-switch" checked="true"/>
                                    @else

                                        <input onchange="changeState('{{$blog->token}}')" type="checkbox" class="js-switch"/>
                                    @endif
                                     
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group">
                                        <a class="btn btn-link" href="{{route('blog.edit', $blog->token)}}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>

                                        <a class="btn btn-link" href="{{route('blog.preview', $blog->token)}}">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <button class="btn btn-link" onclick="remove( '{{$blog->token}}' )">
                                            <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                        </button>
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

    @foreach ($blogs as $blog)
        <form id="delete_{{$blog->token}}" action="{{route('blog.delete')}}" method="POST">
            @csrf
            @method('put')
            <input type="hidden" name="token" value="{{$blog->token}}">
        </form>
    @endforeach
    
@endsection

@push('scripts')

    <script>
        function changeState(token){
            axios.post("{{route('blog.changeState')}}", {token: token}).then( (response) => {
                toastr.success(response.data.message);
            } )
        }

        function remove(token) {
            swal({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You will not be able to recover this post!') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ed5565",
                confirmButtonText: "Si, deseo eliminarla",
                closeOnConfirm: false,
                cancelButtonColor: "#ed5565",
                cancelButtonText: "Cancelar",
            }, function() {
                $('#delete_' + token).submit();

            });
        }
    </script>

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

    <script type="text/javascript" src="{{ url('/') }}/js/tables.js"></script>
@endpush