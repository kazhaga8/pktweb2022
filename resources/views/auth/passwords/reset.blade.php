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
                            <h2 class="text-uppercase">
                                <a href="index.html" class="text-success">
                                    <span><img src="{{ url('public') }}/assets/images/logo.png" alt="" height="36"></span>
                                </a>
                            </h2>
                            <h4 class="text-uppercase text-white font-bold m-b-0">{{ __('Reset Password') }}</h4>
                        </div>
                        <div class="account-content">
                            <!-- <div class="text-center m-b-20">
                                <p class="text-muted m-b-0 font-13">Enter your email address and we'll send you an email with instructions to reset your password. </p>
                            </div> -->
                            <form class="form-horizontal" method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">


                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input id="email" type="email" class="form-control @error('email') parsley-error @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="{{ __('E-Mail Address') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input id="password" type="password" class="form-control @error('password') parsley-error @enderror" name="password" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password" autofocus>

                                        @error('password')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input id="password-confirm" type="password" class="form-control @error('password_confirmation') parsley-error @enderror" name="password_confirmation" placeholder="{{ __('Password') }}" required autocomplete="new-password" autofocus>

                                        @error('password_confirmation')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group account-btn text-center m-t-10">
                                    <div class="col-xs-12">
                                        <button class="btn w-md btn-bordered btn-success waves-effect waves-light" type="submit">{{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>

                            </form>

                            <div class="clearfix"></div>

                        </div>
                    </div>
                    <!-- end card-box-->


                    <div class="row m-t-50">
                        <div class="col-sm-12 text-center">
                            <p class="text-muted">Already have account?<a href="{{ route('login') }}" class="text-primary m-l-5"><b>Sign In</b></a></p>
                        </div>
                    </div>

                </div>
                <!-- end wrapper -->

            </div>
        </div>
    </div>
</section>
<!-- END HOME -->
@endsection