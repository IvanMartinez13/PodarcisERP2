@extends('layouts.guest')

@section('content')
    <div class="auth_wrapper glassCard">
        <h5>{{ __('Forgot your password?') }}</h5>
        <hr class="border-white">
        <div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="container">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    <div class="row mt-3">
                        <div class="col-12 mb-3">
                            <label for="email">{{ __('forms.email') }}: </label>
                            <input type="email" id="email" class="form-control" name="email"
                                placeholder="{{ __('forms.email') }}...">
                        </div>


                    </div>



                    <div class="col-12">
                        <button class="ml-3 btn btn-primary">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>

                </div>
            </form>


        </div>
        <hr class="border-white">
        <div class="px-2">
            Podarcis SL. &copy;
        </div>


    </div>
@endsection
