@php
    $fields = [
        'title' => [
            'title' => __('Title'),
            'required' => true
        ],
        'description' => [
            'type' => 'textarea',
            'title' => __('Description'),
            'required' => false
        ],
        'price' => [
            'title' => __('Price'),
            'required' => true
        ],
        'duration' => [
            'title' => __('Duration'),
            'required' => true
        ],
        'feature_list' => [
            'type' => 'textarea',
            'title' => __('Feature list'),
            'required' => true
        ],
        'button_label' => [
            'title' => __('Button label'),
            'required' => true
        ],
        'button_url' => [
            'title' => __('Button URL'),
            'required' => true
        ],
    ];
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description') }}</label>
        <textarea name="description" class="form-control" placeholder="{{ __('Description') }}">{{ Arr::get($attributes, 'description') }}</textarea>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background image 1') }}</label>
        {!! Form::mediaImage('background_image_1', Arr::get($attributes, 'background_image_1')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background image 2') }}</label>
        {!! Form::mediaImage('background_image_2', Arr::get($attributes, 'background_image_2')) !!}
    </div>

    {!! Theme::partial('shortcodes.includes.tabs', compact('fields', 'attributes')) !!}
</section>
