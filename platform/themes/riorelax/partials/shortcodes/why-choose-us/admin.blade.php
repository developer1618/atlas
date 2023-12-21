@php
    $fields = [
        'title' => [
            'type' => 'text',
            'title' => __('Title'),
        ],
        'percentage' => [
            'type' => 'percentage',
            'title' => __('Percentage'),
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
        <label class="control-label">{{ __('Right Image') }}</label>
        {!! Form::mediaImage('right_image', Arr::get($attributes, 'right_image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background Color') }}</label>
        {!! Form::customColor('background_color', Arr::get($attributes, 'background_color', '#291d16'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background Image') }}</label>
        {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
    </div>

    {!! Theme::partial('shortcodes.includes.tabs', compact('fields', 'attributes')) !!}
</section>
