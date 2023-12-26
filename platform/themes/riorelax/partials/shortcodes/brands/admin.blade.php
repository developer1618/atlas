@php
    $fields = [
        'name' => [
            'title' => __('Name'),
            'required' => true
        ],
        'image' => [
            'type' => 'image',
            'title' => __('Logo'),
            'required' => true
        ],
        'link' => [
            'type' => 'text',
            'title' => __('URL'),
            'required' => false
        ],
    ];
@endphp

<section>
    <div class="form-group">
        <label class="control-label">{{ __('Background color') }}</label>
        {!! Form::customColor('background_color', Arr::get($attributes, 'background_color', '#f7f5f1'), ['class' => 'form-control']) !!}
    </div>

    {!! Theme::partial('shortcodes.includes.tabs', compact('fields', 'attributes')) !!}
</section>
