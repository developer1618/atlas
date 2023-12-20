@php
    $margin = $margin ?? false;
@endphp

<div @class(['single-services shadow-block mb-30', 'ser-m' => !$margin])>
    <div class="services-thumb hover-zoomin wow fadeInUp animated">
        @if ($images = $room->images)
            <a href="{{ $room->url }}?start_date={{ BaseHelper::stringify(request()->query('start_date', $startDate)) }}&end_date={{ BaseHelper::stringify(request()->query('end_date', $endDate)) }}&adults={{ BaseHelper::stringify(request()->query('adults', 1)) }}">
                <img src="{{ RvMedia::getImageUrl(Arr::first($images), 'medium') }}" alt="{{ $room->name }}">
            </a>
        @endif
    </div>
    <div class="services-content">
        <div class="day-book">
            <ul>
                <li>
                    <form action="{{ route('public.booking') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="start_date" value="{{ $startDate->format('d-m-Y') }}">
                        <input type="hidden" name="end_date" value="{{ $endDate->format('d-m-Y') }}">
                        <input type="hidden" name="adults" value="{{ $adults }}">
                        <button class="book-button-custom" type="submit" data-animation="fadeInRight" data-delay=".8s">
                            {{ __('BOOK NOW FOR :price', ['price' => format_price($room->total_price)]) }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <h4><a href="{{ $room->url }}">{{ $room->name }}</a></h4>
        @if ($description = $room->description)
            <p class="room-item-custom-truncate" title="{{ $description }}">{!! BaseHelper::clean($description) !!}</p>
        @endif

        @if ($room->amenities->isNotEmpty())
            <div class="icon">
                <ul class="d-flex justify-content-evenly">
                    @foreach ($room->amenities->take(6) as $amenity)
                        @if ($image = $amenity->getMetaData('icon_image', true) )
                            <li>
                                <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $amenity->name }}">
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
