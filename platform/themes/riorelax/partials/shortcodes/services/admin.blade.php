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
        <label class="control-label">{{ __('Left image') }}</label>
        {!! Form::mediaImage('left_image', Arr::get($attributes, 'left_image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Right floating image') }}</label>
        {!! Form::mediaImage('right_floating_image', Arr::get($attributes, 'right_floating_image')) !!}
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="button_label">{{ __('Button label') }}</label>
            <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" placeholder="{{ __('Button label') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="button_label">{{ __('Button URL') }}</label>
            <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" placeholder="{{ __('Button URL') }}">
        </div>
    </div>
</section>
