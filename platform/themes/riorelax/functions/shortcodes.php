<?php

use Botble\Faq\Models\Faq;
use Botble\Faq\Models\FaqCategory;
use Botble\Gallery\Models\Gallery;
use Botble\Hotel\Facades\HotelHelper;
use Botble\Hotel\Models\Amenity;
use Botble\Hotel\Models\Food;
use Botble\Hotel\Models\Room;
use Botble\Hotel\Models\Service;
use Botble\Hotel\Repositories\Interfaces\RoomInterface;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Team\Models\Team;
use Botble\Testimonial\Models\Testimonial;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Botble\Theme\Supports\Youtube;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

app()->booted(function () {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    if (is_plugin_active('simple-slider')) {
        add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function (): string|null {
            return Theme::getThemeNamespace('partials.shortcodes.simple-slider.index');
        });

        Shortcode::register('hero-banner-with-booking-form', __('Hero banner with booking form'), __('Hero banner with booking form'), function (ShortcodeCompiler $shortcode): string|null {
            Theme::asset()->container('footer')->usePath()->add('datepicker-js', 'plugins/datepicker/bootstrap-datepicker.js', ['jquery']);
            if (App::getLocale() !== 'en') {
                Theme::asset()
                    ->container('footer')
                    ->usePath(false)
                    ->add('bootstrap-datepicker-locale', sprintf('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.%s.min.js', App::getLocale()), ['datepicker-js']);
            }

            return Theme::partial('shortcodes.hero-banner-with-booking-form.index', compact('shortcode'));
        });

        Shortcode::setAdminConfig('hero-banner-with-booking-form', function (array $attributes): string|null {
            return Theme::partial('shortcodes.hero-banner-with-booking-form.admin', compact('attributes'));
        });
    }

    if (is_plugin_active('hotel')) {
        Shortcode::register('check-availability-form', __('Check availability form'), __('Check availability form'), function (ShortcodeCompiler $shortcode): string|null {
            return Theme::partial('shortcodes.check-availability-form.index', compact('shortcode'));
        });

        Shortcode::register('booking-form', __('Booking form'), __('Booking form'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = $shortcode->limit ?: 6;

            $rooms = Room::query()
                ->wherePublished()
                ->limit($limit)
                ->pluck('name', 'id');

            return Theme::partial('shortcodes.booking-form.index', compact('shortcode', 'rooms'));
        });

        Shortcode::setAdminConfig('booking-form', function (array $attributes): string|null {
            return Theme::partial('shortcodes.booking-form.admin', compact('attributes'));
        });

        Shortcode::register('featured-rooms', __('Featured Rooms'), __('Featured Rooms'), function (ShortcodeCompiler $shortcode): string|null {
            if (!$shortcode->room_ids) {
                return null;
            }

            $roomIds = explode(',', $shortcode->room_ids);

            if (!$roomIds) {
                return null;
            }

            [$startDate, $endDate, $adults, $nights] = HotelHelper::getRoomBookingParams();

            $params = [
                'condition' => [
                    ['id', 'IN', $roomIds],
                ],
                'with' => [
                    'amenities',
                    'amenities.metadata',
                    'slugable',
                    'activeBookingRooms' => function ($query) use ($startDate, $endDate) {
                        return $query
                            ->where(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '>=', $startDate)
                                    ->whereDate('start_date', '<=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('end_date', '>=', $startDate)
                                    ->whereDate('end_date', '<=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '<=', $startDate)
                                    ->whereDate('end_date', '>=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '>=', $startDate)
                                    ->whereDate('end_date', '<=', $endDate);
                            });
                    },
                    'activeRoomDates' => function ($query) use ($startDate, $endDate) {
                        return $query
                            ->whereDate('start_date', '>=', $startDate->startOfDay())
                            ->whereDate('end_date', '<=', $endDate->endOfDay())
                            ->take(40);
                    },
                ],
            ];

            $queriedRooms = app(RoomInterface::class)->getRooms([], $params);

            $rooms = [];

            $dateFormat = 'Y-m-d';

            $condition = [
                'start_date' => $startDate->format($dateFormat),
                'end_date' => $endDate->format($dateFormat),
                'adults' => $adults,
            ];

            foreach ($queriedRooms as &$room) {
                if ($room->isAvailableAt($condition)) {
                    $room->total_price = $room->getRoomTotalPrice($startDate, $endDate);

                    $rooms[] = $room;
                }
            }

            return Theme::partial('shortcodes.featured-rooms.index', compact('shortcode', 'rooms', 'startDate', 'endDate', 'adults', 'nights'));
        });

        Shortcode::setAdminConfig('featured-rooms', function (array $attributes): string|null {
            $rooms = Room::query()
                ->wherePublished()
                ->pluck('name', 'id');

            $roomIds = explode(',', Arr::get($attributes, 'room_ids'));

            return Theme::partial('shortcodes.featured-rooms.admin', compact('attributes', 'rooms', 'roomIds'));
        });

        Shortcode::register('featured-amenities', __('Featured amenities'), __('Featured amenities'), function (ShortcodeCompiler $shortcode): string|null {
            if (!$shortcode->amenity_ids) {
                return null;
            }

            $amenityIds = explode(',', $shortcode->amenity_ids);

            if (!$amenityIds) {
                return null;
            }

            $amenities = Amenity::query()
                ->wherePublished()
                ->whereIn('id', $amenityIds)
                ->get();

            return Theme::partial('shortcodes.featured-amenities.index', compact('shortcode', 'amenities'));
        });

        Shortcode::setAdminConfig('featured-amenities', function (array $attributes): string|null {
            $amenities = Amenity::query()
                ->wherePublished()
                ->pluck('name', 'id')
                ->all();

            $amenityIds = explode(',', Arr::get($attributes, 'amenity_ids'));

            return Theme::partial('shortcodes.featured-amenities.admin', compact('attributes', 'amenities', 'amenityIds'));
        });

        Shortcode::register('room-list', __('Room list'), __('Room list'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = $shortcode->limit ?: 6;

            $rooms = Room::query()
                ->wherePublished()
                ->limit($limit)
                ->get();

            [$startDate, $endDate, $adults, $nights] = HotelHelper::getRoomBookingParams();

            return Theme::partial('shortcodes.room-list.index', compact('shortcode', 'rooms', 'startDate', 'endDate', 'adults', 'nights'));
        });

        Shortcode::setAdminConfig('room-list', function (array $attributes): string|null {
            return Theme::partial('shortcodes.room-list.admin', compact('attributes'));
        });

        Shortcode::register('food-list', __('Food list'), __('Food list'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = $shortcode->limit ?: 6;

            $foods = Food::query()
                ->wherePublished()
                ->limit($limit)
                ->get();

            return Theme::partial('shortcodes.food-list.index', compact('shortcode', 'foods'));
        });

        Shortcode::setAdminConfig('food-list', function (array $attributes): string|null {
            return Theme::partial('shortcodes.food-list.admin', compact('attributes'));
        });

        Shortcode::register('cart-list', __('Cart list'), __('Cart list'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = $shortcode->limit ?: 6;

            $foods = Food::query()
                ->wherePublished()
                ->limit($limit)
                ->get();

            return Theme::partial('shortcodes.cart-list.index', compact('shortcode', 'foods'));
        });

        Shortcode::setAdminConfig('cart-list', function (array $attributes): string|null {
            return Theme::partial('shortcodes.cart-list.admin', compact('attributes'));
        });

        Shortcode::register('all-rooms', __('All Rooms'), __('All Rooms'), function (): string|null {
            $request = request();

            [$startDate, $endDate, $adults, $nights] = HotelHelper::getRoomBookingParams();

            $filters = [
                'keyword' => $request->query('q'),
            ];

            $params = [
                'paginate' => [
                    'per_page' => 100,
                    'current_paged' => $request->integer('page', 1),
                ],
                'with' => [
                    'amenities',
                    'amenities.metadata',
                    'slugable',
                    'activeBookingRooms' => function ($query) use ($startDate, $endDate) {
                        return $query
                            ->where(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '>=', $startDate)
                                    ->whereDate('start_date', '<=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('end_date', '>=', $startDate)
                                    ->whereDate('end_date', '<=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '<=', $startDate)
                                    ->whereDate('end_date', '>=', $endDate);
                            })
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                return $query
                                    ->whereDate('start_date', '>=', $startDate)
                                    ->whereDate('end_date', '<=', $endDate);
                            });
                    },
                    'activeRoomDates' => function ($query) use ($startDate, $endDate) {
                        return $query
                            ->whereDate('start_date', '>=', $startDate->startOfDay())
                            ->whereDate('end_date', '<=', $endDate->endOfDay())
                            ->take(40);
                    },
                ],
            ];

            $queriedRooms = app(RoomInterface::class)->getRooms($filters, $params);

            $rooms = [];

            $dateFormat = 'Y-m-d';

            $condition = [
                'start_date' => $startDate->format($dateFormat),
                'end_date' => $endDate->format($dateFormat),
                'adults' => $adults,
            ];

            foreach ($queriedRooms as &$room) {
                if ($room->isAvailableAt($condition)) {
                    $room->total_price = $room->getRoomTotalPrice($startDate, $endDate);

                    $rooms[] = $room;
                }
            }

            $rooms = new LengthAwarePaginator($rooms, count($rooms), 100, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);

            return Theme::partial('shortcodes.all-rooms.index', compact('rooms', 'startDate', 'endDate', 'nights', 'adults'));
        });

        Shortcode::register('service-list', __('Service list'), __('Service list'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = $shortcode->limit ?: 6;

            $services = Service::query()
                ->wherePublished()
                ->limit($limit)
                ->get();

            return Theme::partial('shortcodes.service-list.index', compact('shortcode', 'services'));
        });

        Shortcode::setAdminConfig('service-list', function (array $attributes): string|null {
            return Theme::partial('shortcodes.service-list.admin', compact('attributes'));
        });
    }

    if (is_plugin_active('testimonial')) {
        Shortcode::register('testimonials', __('Testimonials'), __('Testimonials'), function (ShortcodeCompiler $shortcode): string|null {
            if (!$shortcode->testimonial_ids) {
                return null;
            }

            $testimonialIds = explode(',', $shortcode->testimonial_ids);

            if (!$testimonialIds) {
                return null;
            }

            $testimonials = Testimonial::query()
                ->wherePublished()
                ->whereIn('id', $testimonialIds)
                ->get();

            return Theme::partial('shortcodes.testimonials.index', compact('shortcode', 'testimonials'));
        });

        Shortcode::setAdminConfig('testimonials', function (array $attributes): string|null {
            $testimonials = Testimonial::query()
                ->wherePublished()
                ->pluck('name', 'id')
                ->all();

            $testimonialIds = explode(',', Arr::get($attributes, 'testimonial_ids'));

            return Theme::partial('shortcodes.testimonials.admin', compact('attributes', 'testimonials', 'testimonialIds'));
        });
    }

    Shortcode::register('about-us', __('About Us'), __('About Us'), function (ShortcodeCompiler $shortcode): string|null {
        $highlightArray = explode('; ', $shortcode->highlights);

        return Theme::partial('shortcodes.about-us.index', compact('shortcode', 'highlightArray'));
    });

    Shortcode::setAdminConfig('about-us', function (array $attributes): string {
        return Theme::partial('shortcodes.about-us.admin', compact('attributes'));
    });

    Shortcode::register('why-choose-us', __('Why Choose Us'), __('Why Choose Us'), function (ShortcodeCompiler $shortcode): string|null {
        $tabs = Shortcode::fields()->getTabsData(['title', 'percentage'], $shortcode);

        return Theme::partial('shortcodes.why-choose-us.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('why-choose-us', function (array $attributes): string {
        return Theme::partial('shortcodes.why-choose-us.admin', compact('attributes'));
    });

    Shortcode::register('services', __('Services'), __('Services'), function (ShortcodeCompiler $shortcode): string|null {
        return Theme::partial('shortcodes.services.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('services', function (array $attributes): string {
        return Theme::partial('shortcodes.services.admin', compact('attributes'));
    });

    if (is_plugin_active('newsletter')) {
        Shortcode::register('newsletter', __('Newsletter'), __('Newsletter'), function (ShortcodeCompiler $shortcode): string|null {
            return Theme::partial('shortcodes.newsletter.index', compact('shortcode'));
        });

        Shortcode::setAdminConfig('newsletter', function (array $attributes): string {
            return Theme::partial('shortcodes.newsletter.admin', compact('attributes'));
        });
    }

    if (is_plugin_active('contact')) {
        add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
            return Theme::getThemeNamespace('partials.shortcodes.contact-form.index');
        }, 120);

        Shortcode::setAdminConfig('contact-form', function (array $attributes): string {
            return Theme::partial('shortcodes.contact-form.admin', compact('attributes'));
        });
    }

    Shortcode::register('brands', __('Brands'), __('Brands'), function (ShortcodeCompiler $shortcode): string|null {
        $tabs = Shortcode::fields()->getTabsData(['name', 'image', 'link'], $shortcode);

        return Theme::partial('shortcodes.brands.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('brands', function (array $attributes): string|null {
        return Theme::partial('shortcodes.brands.admin', compact('attributes'));
    });

    Shortcode::register('feature-area', __('Feature area'), __('Feature area'), function (ShortcodeCompiler $shortcode): string|null {
        return Theme::partial('shortcodes.feature-area.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('feature-area', function (array $attributes): string|null {
        return Theme::partial('shortcodes.feature-area.admin', compact('attributes'));
    });

    Shortcode::register('pricing', __('Pricing'), __('Pricing'), function (ShortcodeCompiler $shortcode): string|null {
        $tabs = Shortcode::fields()->getTabsData([
            'title',
            'description',
            'price',
            'duration',
            'feature_list',
            'button_label',
            'button_url',
        ], $shortcode);

        return Theme::partial('shortcodes.pricing.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('pricing', function (array $attributes): string|null {
        return Theme::partial('shortcodes.pricing.admin', compact('attributes'));
    });

    Shortcode::register('intro-video', __('Intro Video'), __('Intro Video'), function (ShortcodeCompiler $shortcode): string|null {
        $shortcode->youtube_video_id = $shortcode->youtube_url ? Youtube::getYoutubeVideoID($shortcode->youtube_url) : null;

        return Theme::partial('shortcodes.intro-video.index', compact('shortcode'));
    });

    Shortcode::setAdminConfig('intro-video', function (array $attributes): string|null {
        return Theme::partial('shortcodes.intro-video.admin', compact('attributes'));
    });

    Shortcode::register('user-profile', __('User profile'), __('User profile'), function (ShortcodeCompiler $shortcode): string|null {
        $tabs = Shortcode::fields()->getTabsData(['title', 'percentage',], $shortcode);

        return Theme::partial('shortcodes.user-profile.index', compact('shortcode', 'tabs'));
    });

    Shortcode::setAdminConfig('user-profile', function (array $attributes): string|null {
        return Theme::partial('shortcodes.user-profile.admin', compact('attributes'));
    });

    if (is_plugin_active('blog')) {
        Shortcode::register('news', __('News'), __('News'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = (int) $shortcode->limit ?: 4;

            $posts = match ($shortcode->type) {
                'popular' => get_popular_posts($limit),
                'featured' => get_featured_posts($limit),
                'recent' => get_recent_posts($limit),
                default => get_latest_posts($limit),
            };

            if ($posts->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.news.index', compact('shortcode', 'posts'));
        });

        Shortcode::setAdminConfig('news', function (array $attributes): string|null {
            $types = [
                'latest' => __('Latest'),
                'popular' => __('Popular'),
                'featured' => __('Featured'),
                'recent' => __('Recent'),
            ];

            return Theme::partial('shortcodes.news.admin', compact('attributes', 'types'));
        });
    }

    if (is_plugin_active('team')) {
        Shortcode::register('teams', __('Team'), __('Team'), function (ShortcodeCompiler $shortcode): string|null {
            if (!$shortcode->team_ids) {
                return null;
            }

            $teamIds = explode(',', $shortcode->team_ids);

            if (!$teamIds) {
                return null;
            }

            $teams = Team::query()
                ->whereIn('id', $teamIds)
                ->wherePublished()
                ->get();

            return Theme::partial('shortcodes.teams.index', compact('shortcode', 'teams'));
        });

        Shortcode::setAdminConfig('teams', function (array $attributes): string|null {
            $teams = Team::query()
                ->wherePublished()
                ->pluck('name', 'id')
                ->all();

            $teamIds = explode(',', Arr::get($attributes, 'team_ids'));

            return Theme::partial('shortcodes.teams.admin', compact('attributes', 'teams', 'teamIds'));
        });
    }

    if (is_plugin_active('faq')) {
        Shortcode::register('faqs', __('FAQs'), __('FAQs'), function (ShortcodeCompiler $shortcode): string|null {
            $categoryIds = $shortcode->category_ids ? explode(',', $shortcode->category_ids) : [];

            $faqs = collect();

            if (!empty($categoryIds)) {
                $faqs = Faq::query()
                    ->whereIn('category_id', $categoryIds)
                    ->wherePublished()
                    ->get();
            }

            return Theme::partial('shortcodes.faqs.index', compact('shortcode', 'faqs'));
        });

        Shortcode::setAdminConfig('faqs', function (array $attributes): string|null {
            $categories = FaqCategory::query()
                ->pluck('name', 'id')
                ->toArray();
            $galleries = Gallery::query()
                ->wherePublished()
                ->pluck('name', 'id')
                ->toArray();

            $categoryIds = explode(',', Arr::get($attributes, 'category_ids', ''));

            return Theme::partial(
                'shortcodes.faqs.admin',
                compact('attributes', 'categories', 'categoryIds', 'galleries')
            );
        });
    }

    if (is_plugin_active('gallery')) {
        Shortcode::register('galleries', __('Galleries'), __('Galleries'), function (ShortcodeCompiler $shortcode): string|null {
            $limit = (int) $shortcode->limit ?: 5;

            $galleries = get_galleries($limit);

            if ($galleries->isEmpty()) {
                return null;
            }

            return Theme::partial('shortcodes.galleries.index', compact('shortcode', 'galleries'));
        });

        Shortcode::setAdminConfig('galleries', function (array $attributes): string|null {
            $types = [
                'latest' => __('Latest'),
                'popular' => __('Popular'),
                'featured' => __('Featured'),
                'recent' => __('Recent'),
            ];

            return Theme::partial('shortcodes.galleries.admin', compact('attributes', 'types'));
        });
    }
});
