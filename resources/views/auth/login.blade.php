@extends('layouts.log-reg')

@section('title', 'Login')


@section('content')

    <form class="form-horizontal form-material text-center" id="login-reg" action="{{ route('login') }}" method="post">
        @csrf
        <a href="javascript:void(0)" class="db">
            <img src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" width="35%" />
            <br />
        </a>

        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input name="password" class="form-control" type="password" placeholder="Password">
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <div class="d-flex no-block align-items-center">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">Remember me</label>
                    </div>
                    {{--                        <div class="ml-auto"> --}}
                    {{--                            <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot Password?</a> --}}
                    {{--                        </div> --}}
                </div>
            </div>
        </div>
        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Log In</button>
            </div>
            <div class="col-xs-12 mt-4">
                {{--                    <a href="{{ route('register') }}" id="to-recover" class="text-muted" > --}}
                {{--                        Don't have an account? Register here</a> --}}
            </div>
        </div>
    </form>
    {{-- <div class="container"> --}}
    {{--    <div class="row justify-content-center"> --}}
    {{--        <div class="col-md-8"> --}}
    {{--            <div class="card"> --}}
    {{--                <div class="card-header">{{ __('Login') }}</div> --}}

    {{--                <div class="card-body"> --}}
    {{--                    <form method="POST" action="{{ route('login') }}"> --}}
    {{--                        @csrf --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

    {{--                            <div class="col-md-6"> --}}
    {{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}

    {{--                                @error('email') --}}
    {{--                                    <span class="invalid-feedback" role="alert"> --}}
    {{--                                        <strong>{{ $message }}</strong> --}}
    {{--                                    </span> --}}
    {{--                                @enderror --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> --}}

    {{--                            <div class="col-md-6"> --}}
    {{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> --}}

    {{--                                @error('password') --}}
    {{--                                    <span class="invalid-feedback" role="alert"> --}}
    {{--                                        <strong>{{ $message }}</strong> --}}
    {{--                                    </span> --}}
    {{--                                @enderror --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <div class="col-md-6 offset-md-4"> --}}
    {{--                                <div class="form-check"> --}}
    {{--                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> --}}

    {{--                                    <label class="form-check-label" for="remember"> --}}
    {{--                                        {{ __('Remember Me') }} --}}
    {{--                                    </label> --}}
    {{--                                </div> --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-0"> --}}
    {{--                            <div class="col-md-8 offset-md-4"> --}}
    {{--                                <button type="submit" class="btn btn-primary"> --}}
    {{--                                    {{ __('Login') }} --}}
    {{--                                </button> --}}

    {{--                                @if (Route::has('password.request')) --}}
    {{--                                    <a class="btn btn-link" href="{{ route('password.request') }}"> --}}
    {{--                                        {{ __('Forgot Your Password?') }} --}}
    {{--                                    </a> --}}
    {{--                                @endif --}}
    {{--                            </div> --}}
    {{--                        </div> --}}
    {{--                    </form> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{-- </div> --}}
@endsection
