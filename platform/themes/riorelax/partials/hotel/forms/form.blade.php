@php
    Theme::asset()->container('footer')->usePath()->add('datepicker-js', 'plugins/datepicker/bootstrap-datepicker.js', ['jquery']);
    if (App::getLocale() !== 'en') {
        Theme::asset()
            ->container('footer')
            ->usePath(false)
            ->add('bootstrap-datepicker-locale', sprintf('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.%s.min.js', App::getLocale()), ['datepicker-js']);
    }
@endphp

@if (is_plugin_active('hotel'))
    @php
        $startDate = request()->query('start_date', Carbon\Carbon::now()->format('d-m-Y'));
        $endDate = request()->query('end_date', Carbon\Carbon::now()->addDay()->format('d-m-Y'));
        $adults = request()->query('adults', 1);
    @endphp

    <form action="{{ $availableForBooking ? route('public.booking') : route('public.rooms') }}" method="{{ $availableForBooking ? 'POST' : 'GET' }}" class="contact-form mt-30 form-booking">
        @if ($availableForBooking)
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
        @endif

        @switch($style)
            @case(2)
                <div class="row align-items-center">
                    @if (! empty($title))
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-30">
                                <h2>{!! BaseHelper::clean($title) !!}</h2>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 col-md-6 mb-30">
                        <div class="contact-field p-relative c-name">
                            <label for="availability-form-start-date"><i class="fal fa-badge-check"></i>{{ __('Check In Date') }}</label>
                            <input
                                id="availability-form-start-date"
                                autocomplete="off"
                                class="departure-date
                                date-picker"
                                data-start-date="{{ $availableForBooking ? old('start_date', $startDate) : $startDate }}"
                                data-locale="{{ App::getLocale() }}"
                                type="text" placeholder="dd-mm-yyyy"
                                value="{{ $availableForBooking ? old('start_date', $startDate) : $startDate }}"
                                name="start_date"
                            >
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-30">
                        <div class="contact-field p-relative c-name">
                            <label for="availability-form-end-date"><i class="fal fa-times-octagon"></i>{{ __('Check Out Date') }}</label>
                            <input
                                type="text"
                                id="availability-form-end-date"
                                autocomplete="off"
                                class="arrival-date date-picker"
                                data-start-date="{{ $availableForBooking ? old('end_date', $endDate) : $endDate }}"
                                data-locale="{{ App::getLocale() }}"
                                placeholder="dd-mm-yyyy"
                                value="{{ $availableForBooking ? old('end_date', $endDate) : $endDate }}"
                                name="end_date"
                            >
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-30">
                        <div class="contact-field p-relative c-name">
                            <label for="adults"><i class="fal fa-users"></i>{{ __('Guests') }}</label>
                            <select name="adults" id="adults">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" @selected(BaseHelper::stringify($availableForBooking ? old('adults', 1) == $i : $adults) == $i)>{{ $i }} {{ $i == 1 ? __('Guest') : __('Guests') }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="slider-btn">
                            <button type="submit" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">
                                {{ $availableForBooking ? __('Book Now') : __('Check Availability') }}
                            </button>
                        </div>
                    </div>
                </div>
                @break
            @default
                <div class="row booking-area">
                    @if (! empty($title))
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-30">
                                <h2>{!! BaseHelper::clean($title) !!}</h2>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12">
                        <div class="contact-field p-relative c-name mb-20">
                            <label for="room-detail-booking-form-start-date"><i class="fal fa-badge-check"></i>{{ __('Check In Date') }}</label>
                            <input
                                type="text"
                                id="room-detail-booking-form-start-date"
                                class="departure-date date-picker"
                                autocomplete="off"
                                placeholder="dd-mm-yyyy"
                                data-start-date="{{ $startDate ?: old('start_date', $startDate) }}"
                                data-date-format="dd-mm-yyyy"
                                data-locale="{{ App::getLocale() }}"
                                value="{{ $startDate ?: old('start_date', $startDate) }}"
                                name="start_date"
                            >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-field p-relative c-subject mb-20">
                            <label for="room-detail-booking-form-end-date"><i class="fal fa-times-octagon"></i>{{ __('Check Out Date') }}</label>
                            <input
                                type="text"
                                id="room-detail-booking-form-end-date"
                                class="arrival-date date-picker"
                                autocomplete="off"
                                placeholder="dd-mm-yyyy"
                                data-start-date="{{ $endDate ?: old('end_date', $endDate) }}"
                                data-date-format="dd-mm-yyyy"
                                data-locale="{{ App::getLocale() }}"
                                value="{{ $endDate ?: old('end_date', $endDate) }}"
                                name="end_date"
                            >
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-field p-relative c-subject mb-20">
                            <label for="booking-form-widget-check-in"><i class="fal fa-users"></i>{{ __('Guests') }}</label>
                            <select name="adults" id="booking-form-widget-check-in">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" @selected(BaseHelper::stringify($availableForBooking ? old('adults', 1) == $i : $adults) == $i )>{{ $i }} {{ $i == 1 ? __('Guest') : __('Guests') }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="slider-btn mt-15">
                            <button type="submit" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">
                                <span>{{ $availableForBooking ? __('Book Now') : __('Check Availability') }}</span>
                            </button>
                        </div>
                    </div>
                </div>
        @endswitch
    </form>
@endif
