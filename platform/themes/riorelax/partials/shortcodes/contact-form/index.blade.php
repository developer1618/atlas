<section id="contact" class="contact-area after-none contact-bg pt-90 pb-90 p-relative fix">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-4 order-1">
                <div class="contact-info">
                    @if($shortcode->address_label || $shortcode->address_detail)
                        <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            @if($addressIcon = $shortcode->address_icon)
                                <div class="float-start f-cta-icon">
                                    <i class="{{ $addressIcon }}"></i>
                                </div>
                            @endif

                            @if($addressLabel = $shortcode->address_label)
                                <h5>{{ $addressLabel }}</h5>
                            @endif

                            @if($addressDetail = $shortcode->address_detail)
                                <p>
                                    {!! BaseHelper::clean($addressDetail) !!}
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($shortcode->work_time_label || $shortcode->work_time_detail)
                        <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            @if($workTimeIcon = $shortcode->work_time_icon)
                                <div class="float-start f-cta-icon">
                                    <i class="{{ $workTimeIcon }}"></i>
                                </div>
                            @endif

                            @if($workTimeLabel = $shortcode->work_time_label)
                                <h5>{{ $workTimeLabel }}</h5>
                            @endif

                            @if($workTimeDetail = $shortcode->work_time_detail)
                                <p>
                                    {!! BaseHelper::clean($workTimeDetail) !!}
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($shortcode->phone_label && $shortcode->phone_detail)
                        <div class="single-cta pb-30 mb-30 wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            @if($phoneIcon = $shortcode->phone_icon)
                                <div class="float-start f-cta-icon">
                                    <i class="{{ $phoneIcon }}"></i>
                                </div>
                            @endif

                            @if($phoneLabel = $shortcode->phone_label)
                                <h5>{{ $phoneLabel }}</h5>
                            @endif

                            @if($phoneDetail = $shortcode->phone_detail)
                                <p>
                                    {!! BaseHelper::clean($phoneDetail) !!}
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($shortcode->email_label || $shortcode->email_detail)
                        <div class="single-cta wow fadeInUp animated" data-animation="fadeInDown animated" data-delay=".2s">
                            @if($emailIcon = $shortcode->email_icon)
                                <div class="float-start f-cta-icon">
                                    <i class="{{ $emailIcon }}"></i>
                                </div>
                            @endif

                            @if($emailLabel = $shortcode->email_label)
                                <h5>{{ $emailLabel }}</h5>
                            @endif

                            @if($emailDetail = $shortcode->email_detail)
                                <p>
                                    {!! BaseHelper::clean($emailDetail) !!}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-8 order-2">
                <div class="contact-bg02">
                    @if($title = $shortcode->title)
                        <div class="section-title center-align mb-40 text-center wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                            <h2>
                                {!! BaseHelper::clean($title) !!}
                            </h2>
                        </div>
                    @endif
                    {!! Form::open(['route' => 'public.send.contact', 'class' => 'contact-form cons-contact-form']) !!}

                    {!! apply_filters('pre_contact_form', null) !!}

                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="contact-field p-relative c-name mb-20">
                                <input type="text" id="name" name="name" pattern="[A-Za-z]{3}"  placeholder="{{ __('Name') }}" required />
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="contact-field p-relative c-subject mb-20">
                                <input type="email" id="email" name="email" placeholder="{{ __('Email') }}" required />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact-field p-relative c-subject mb-20">
                                <input type="tel" id="phone" name="phone" placeholder="{{ __('Phone') }}" required />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="contact-field p-relative c-subject mb-20">
                                <input type="text" id="subject" name="subject" placeholder="Subject" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="contact-field p-relative c-message mb-20">
                                <textarea name="content" id="message" cols="30" rows="10" placeholder="{{ __('Write comments') }}"></textarea>
                            </div>

                            @if (is_plugin_active('captcha'))
                                @if (setting('enable_captcha'))
                                    <div class="col-12">
                                        <div class="contact-field p-relative c-subject mb-20">
                                            {!! Captcha::display() !!}
                                        </div>
                                    </div>
                                @endif

                                @if (setting('enable_math_captcha_for_contact_form', 0))
                                    <div class="col-12">
                                        <div class="contact-field p-relative c-subject mb-20">
                                            {!! app('math-captcha')->input(['id' => 'math-group', 'placeholder' => app('math-captcha')->label()]) !!}
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div class="slider-btn mt-10">
                                <button type="submit" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span>{{ $shortcode->button_label ?: __('SUBMIT NOW') }}</span></button>
                            </div>

                            {!! apply_filters('after_contact_form', null) !!}

                            <div class="col-span-12">
                                <div class="contact-form-group mt-4 text-start">
                                    <div class="contact-message contact-success-message" style="display: none"></div>
                                    <div class="contact-message contact-error-message" style="display: none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
