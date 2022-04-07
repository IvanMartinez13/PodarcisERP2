@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-10 my-auto">
            <h2>{{ __('modules.blog') }}</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="breadcrumb-item">
                    <a href="{{ route('blog.index') }}">{{ __('modules.blog') }}</a>
                </li>

                <li class="breadcrumb-item active">
                    <strong>{{ __('forms.edit') }}</strong>
                </li>
            </ol>
        </div>

        <div class="col-2 text-right">
            <a href="{{ route('blog.index') }}" class="btn btn-danger mt-5">{{ __('pagination.return') }}</a>
        </div>

    </div>

    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ __('forms.edit')." ".__('modules.blog') }}</h5>

            <div class="ibox-tools">
                <a href="#" class="collapse-link">
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form action="{{route('blog.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input name="token" type="hidden" value="{{$blog->token}}"/>

                <div class="row">
                    <div class="col-lg-6 mb-3 @error('title') has-error @enderror ">
                        <label for="title">
                            {{__('forms.title')}}:
                        </label>
    
                        <input class="form-control" type="text" id="title" name="title" placeholder="{{__('forms.title')}}..." value="{{$blog->title}}" />
                    </div>
    
                    <div class="col-lg-6 mb-3  @error('image') has-error @enderror ">
                        <label for="image">
                            {{__('forms.image')}}:
                        </label>
    
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="image" type="file" name="image" class="custom-file-input">
                                <label class="custom-file-label" for="image">{{ __('forms.image') }}...</label>
                            </div>
                        </div>
                        @if ($blog->image)
                            <a class="btn btn-link" href="{{url('/storage').$blog->image}}" target="_blank">
                                Ver imagen actual...
                            </a>
                        @endif

    
                    </div>
    
                    <div class="col-lg-12 mb-3  @error('content') has-error @enderror ">
                        <label for="content">
                            {{__('forms.content')}}:
                        </label>
    
                        <textarea id="content" name="content" class="form-control">{{$blog->content}}</textarea>
                    </div>
                </div>
    
                <div class="text-right">
                    <button class="btn btn-primary">
                        {{__('forms.edit')}}
                    </button>
                </div>
            </form>

        </div>
        <div class="ibox-footer">
            Podarcis SL. &copy; {{date('Y')}}
        </div>
    </div>
@endsection


@push('scripts')
    
    <script>

        $(document).ready(function() {
            bsCustomFileInput.init()

            $('#content').summernote({
                placeholder: "{{__('forms.content')}}...",
                height: "300px"
            })
        });

        

    </script>


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                $(document).ready(() => {
                    toastr.error("{{ $error }}")
                })
            </script>
        @endforeach
    @endif
@endpush