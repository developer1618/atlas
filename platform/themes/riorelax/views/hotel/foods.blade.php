@php(Theme::set('pageTitle', __('Foods')))

<section class="container">
    <div class="row">
        <div class="col-lg-8">
            {!! do_shortcode('[all-foods]') !!}
        </div>
        <div class="col-lg-4">
            <div class="sidebar-widget-rooms">
                {!! dynamic_sidebar('foods_sidebar') !!}
            </div>
        </div>
    </div>
</section>
