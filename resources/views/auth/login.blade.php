@extends('layouts.app-login')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-login">
            <div class="col-md-12">
                <div class="card d-border-input">
                    <div class="bg-gradient-secondary card-header justify-content-center text-center"><img height="auto" width="40%" height="40%" src="{{asset('/logo_bahana_dx_trade.png')}}"/></div>
                    <div class="bg-gradient-secondary card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group row justify-content-center">
                                <div class="col-sm-8">

                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend{{ $errors->has('username') ? ' is-invalid d-border-error-icon-login' : '' }}">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        </div>
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid d-border-error-input-login' : '' }}" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username">

                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                {{--<label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>--}}
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-sm-8">

                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend{{ $errors->has('password') ? ' is-invalid d-border-error-icon-login' : '' }}">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid d-border-error-input-login' : '' }}" name="password" required autocomplete="current-password" placeholder="Password">

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>--}}
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">{{ __('Remember Me') }}</span>
                                    </label>
                                </div>

                                {{--<div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>--}}
                            </div>
                            <div class="form-group row mb-0 justify-content-center">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Login') }}
                                    </button>

                                    {{--@if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
