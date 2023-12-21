@php
    Theme::set('pageTitle', 'Forgot password');
@endphp

<section class="about-area about-p pt-60 pb-60 pr-60 pl-60 p-relative fix">
    <div class="container">
        <div class="row flex-row-reverse justify-content-center align-items-center">
            @if ($backgroundImage = theme_option('authentication_forgot_password_background_image'))
                <div class="col-lg-6 col-md-6">
                    <div class="booking-img">
                        <img src="{{ RvMedia::getImageURL($backgroundImage) }}" alt="{{ __('Forgot password') }}" />
                    </div>
                </div>
            @endif
            <div class="col-md-6 col-lg-6">
                <h1>{{ __('Forgot password') }}</h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>{{ __('Enter the email address associated with your account and we’ll send you a link to reset your password') }}
                        </p>

                        <form class="form-horizontal" role="form" method="POST"
                            action="{{ route('customer.password.request') }}">
                            @csrf
                            <div class="form-field-wrapper form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-lg-12 col-md-12">
                                    <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                        <label class="custom-authentication-label" for="email">
                                            <span>{{ __('E-Mail Address') }}</span>
                                        </label>
                                        <input class="custom-authentication-input" type="email" id="email"
                                            name="email" placeholder="{{ __('Email') }}" required />
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="col-md-6 col-md-offset-4 mt-20">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
