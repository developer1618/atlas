@php
    $fields = [
        'title' => [
            'title' => __('Title'),
            'required' => true
        ],
        'percentage' => [
            'type' => 'text',
            'title' => __('Percentage'),
            'required' => false
        ],
    ];
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Image :number', ['number' => 1]) }}</label>
        {!! Form::mediaImage('image_1', Arr::get($attributes, 'image_1')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image :number', ['number' => 2]) }}</label>
        {!! Form::mediaImage('image_2', Arr::get($attributes, 'image_2')) !!}
    </div>

    {!! Theme::partial('shortcodes.includes.tabs', compact('fields', 'attributes')) !!}
</section>
