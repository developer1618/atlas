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
        <label class="control-label">{{ __('Background Color') }}</label>
        {!! Form::customColor('background_color', Arr::get($attributes, 'background_color', '#f7f5f1'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Left floating image') }}</label>
        {!! Form::mediaImage('left_floating_image', Arr::get($attributes, 'left_floating_image')) !!}
    </div>
</section>
