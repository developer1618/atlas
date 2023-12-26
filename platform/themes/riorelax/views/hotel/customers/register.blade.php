@php
    Theme::set('pageTitle', __('Register'));
@endphp

<section class="about-area about-p pt-60 pb-60 pr-60 pl-60 p-relative fix">
    <div class="container">
        <div class="row flex-row-reverse justify-content-center align-items-center">
            @if ($backgroundImage = theme_option('authentication_register_background_image'))
                <div class="col-lg-6 col-md-6">
                    <div class="booking-img">
                        <img src="{{ RvMedia::getImageURL($backgroundImage) }}" alt="{{ __('Register') }}" />
                    </div>
                </div>
            @endif

            <div class="col-xxl-5 col-xl-12 col-lg-12">
                <div class="form-border-box">
                    <form class="form-horizontal" role="form" method="POST"
                        action="{{ route('customer.register.post') }}">
                        <h1 class="normal mb-20">{{ __('Register') }}</h1>
                        @csrf
                        <div class="form-field-wrapper form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div class="col-lg-12 col-md-12">
                                <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                    <label for="first_name" class="custom-authentication-label">
                                        <span>{{ __('First Name') }}</span>
                                    </label>
                                    <input class="custom-authentication-input" type="text" id="first_name"
                                        name="first_name" placeholder="{{ __('First Name') }}" required />
                                </div>
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-field-wrapper form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <div class="col-lg-12 col-md-12">
                                <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                    <label class="custom-authentication-label" for="last_name">
                                        <span>{{ __('Last Name') }}</span>
                                    </label>
                                    <input class="custom-authentication-input" type="text" id="last_name"
                                        name="last_name" placeholder="{{ __('Last Name') }}" required />
                                </div>
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        {!! apply_filters('hotel_customer_register_form_before', null) !!}

                        <div class="form-field-wrapper form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-lg-12 col-md-12">
                                <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                    <label class="custom-authentication-label" for="email">
                                        <span>{{ __('Email') }}</span>
                                    </label>
                                    <input class="custom-authentication-input" type="email" id="email"
                                        name="email" placeholder="{{ __('Enter your email') }}" required />
                                </div>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-field-wrapper form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-lg-12 col-md-12">
                                <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                    <label class="custom-authentication-label" for="password">
                                        <span>{{ __('Password') }}</span>
                                    </label>
                                    <input class="custom-authentication-input" type="password" id="password"
                                        name="password" required />
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div
                            class="form-field-wrapper form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="col-lg-12 col-md-12">
                                <div class="input-md form-full-width contact-field p-relative c-name mb-20">
                                    <label class="custom-authentication-label" for="password_confirmation">
                                        <span>{{ __('Password') }}</span>
                                    </label>
                                    <input class="custom-authentication-input" type="password"
                                        id="password_confirmation" name="password_confirmation" required />
                                </div>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-lg-12 mt-15">
                            <div class="form-group mb-25">
                                <label>
                                    <span class="text-small">
                                        {{ __('Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.') }}
                                    </span>
                                </label>
                            </div>
                            <div class="form-group mb-25">
                                <label class="cb-container">
                                    <input type="checkbox" name="agree_terms_and_policy" id="agree-terms-and-policy"
                                        value="1" @if (old('agree_terms_and_policy') == 1) checked @endif>
                                    <span class="text-small">{{ __('I agree to terms & Policy.') }}</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        @if (is_plugin_active('captcha'))
                            @if (Captcha::isEnabled() && HotelHelper::getSetting('enable_recaptcha_in_register_page', 0))
                                <div class="form-group mb-3">
                                    {!! Captcha::display() !!}
                                </div>
                                @endif @if (HotelHelper::getSetting('enable_math_captcha_in_register_page', 0))
                                    <div class="form-group mb-3">
                                        {!! app('math-captcha')->input([
                                            'class' => 'form-control',
                                            'id' => 'math-group',
                                            'placeholder' => app('math-captcha')->getMathLabelOnly(),
                                        ]) !!}
                                    </div>
                                @endif
                            @endif

                            <div class="form-group mb-3">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="submit btn btn-md btn-black">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\Hotel\Models\Customer::class) !!}
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
