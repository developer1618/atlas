<section class="services-area pb-30">
    <div class="container">
        <div class="row">
            @foreach ($foods as $food)
            <div class="col-xl-4 col-md-6">
                {!! Theme::partial('foods.item', compact('food')) !!}
            </div>
            @endforeach
        </div>
    </div>
</section>