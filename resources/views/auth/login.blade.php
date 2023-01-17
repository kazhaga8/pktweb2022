@extends('webmin.layouts.starter')

@section('content')
<!-- HOME -->
<section>
        <div class="container-alt">
            <div class="row">
                <div class="col-sm-12">

                    <div class="wrapper-page">

                        <div class="m-t-40 account-pages">
                            <div class="text-center account-logo-box">
                                <h2 class="text-uppercase text-white font-bold m-b-0">{{ __('Login') }}</h2>
                            </div>
                            <div class="account-content">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <input id="username" type="text" class="form-control @error('username') parsley-error @enderror" name="username" value="{{ old('username') }}"  placeholder="{{ __('Username / E-Mail Address') }}" required autocomplete="username" autofocus>
                                            @error('username')
                                                <ul class="parsley-errors-list filled">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input id="password" type="password" class="form-control @error('password') parsley-error @enderror" name="password"  placeholder="{{ __('Password') }}" required autocomplete="current-password">
                                            @error('password')
                                                <ul class="parsley-errors-list filled">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <div class="checkbox checkbox-success">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    @if (Route::has('password.request'))
                                    <div class="form-group text-center m-t-30">
                                        <div class="col-sm-12">
                                            <a href="{{ route('password.request') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i>  {{ __('Forgot Your Password?') }}</a>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group account-btn text-center m-t-10">
                                        <div class="col-xs-12">
                                            <button class="btn w-md btn-bordered btn-danger waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                                        </div>
                                    </div>

                                </form>

                                <div class="clearfix"></div>

                            </div>
                        </div>
                        <!-- end card-box-->


                        {{-- <div class="row m-t-50">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                            </div>
                        </div> --}}

                    </div>
                    <!-- end wrapper -->

                </div>
            </div>
        </div>
    </section>
    <!-- END HOME -->
@endsection
