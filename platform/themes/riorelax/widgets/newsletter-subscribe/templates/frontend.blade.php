@if (is_plugin_active('newsletter'))
    <div class="col-xl-4 col-lg-4 col-sm-6">
        <div class="footer-widget mb-30">
            @if ($title = $config['title'])
                <div class="f-widget-title">
                    <h2>{!! BaseHelper::clean($title) !!}</h2>
                </div>
            @endif

            <div class="footer-link" dir="ltr">
                <div class="subricbe p-relative form-newsletter" data-animation="fadeInDown" data-delay=".4s" >
                    <form action="{{ route('public.newsletter.subscribe') }}" method="post" class="newsletter-form">
                        @csrf
                        <input type="email" name="email" placeholder="{{ __('Enter your email...') }}"  class="header-input" required>
                        @if (setting('enable_captcha') && is_plugin_active('captcha'))
                            <div class="form-group">
                                {!! Captcha::display() !!}
                            </div>
                        @endif
                        <button type="submit" class="btn header-btn"> <i class="fas fa-location-arrow"></i> </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endif
