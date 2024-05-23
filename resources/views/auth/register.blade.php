@extends('layouts.log-reg')

@section('title', 'Register')


@section('content')

    <form class="form-horizontal form-material text-center" id="login-reg" action="{{ route('register') }}" method="post">
        @csrf
        <a href="javascript:void(0)" class="db">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="Home" />
            <br />
            <img src="{{ asset('assets/images/logo-text.png') }}" alt="Home" />
        </a>

        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group m-t-40">
            <div class="col-xs-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confrim Password">
            </div>
        </div>

        <div class="form-group text-center m-t-20">
            <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Register</button>
            </div>
            <div class="col-xs-12 mt-4">
                <a href="{{ route('login') }}" id="to-recover" class="text-muted">
                    Already have an account? Login here</a>
            </div>
        </div>

    </form>

    {{-- <div class="container"> --}}
    {{--    <div class="row justify-content-center"> --}}
    {{--        <div class="col-md-8"> --}}
    {{--            <div class="card"> --}}
    {{--                <div class="card-header">{{ __('Register') }}</div> --}}

    {{--                <div class="card-body"> --}}
    {{--                    <form method="POST" action="{{ route('register') }}"> --}}
    {{--                        @csrf --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label> --}}

    {{--                            <div class="col-md-6"> --}}
    {{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" --}}
    {{--                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> --}}

    {{--                                @error('name') --}}
    {{--                                    <span class="invalid-feedback" role="alert"> --}}
    {{--                                        <strong>{{ $message }}</strong> --}}
    {{--                                    </span> --}}
    {{--                                @enderror --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> --}}

    {{--                            <div class="col-md-6"> --}}
    {{--                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> --}}

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
    {{--                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> --}}

    {{--                                @error('password') --}}
    {{--                                    <span class="invalid-feedback" role="alert"> --}}
    {{--                                        <strong>{{ $message }}</strong> --}}
    {{--                                    </span> --}}
    {{--                                @enderror --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-3"> --}}
    {{--                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label> --}}

    {{--                            <div class="col-md-6"> --}}
    {{--                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> --}}
    {{--                            </div> --}}
    {{--                        </div> --}}

    {{--                        <div class="row mb-0"> --}}
    {{--                            <div class="col-md-6 offset-md-4"> --}}
    {{--                                <button type="submit" class="btn btn-primary"> --}}
    {{--                                    {{ __('Register') }} --}}
    {{--                                </button> --}}
    {{--                            </div> --}}
    {{--                        </div> --}}
    {{--                    </form> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    {{-- </div> --}}
@endsection
