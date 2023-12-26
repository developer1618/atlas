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
        <label class="control-label">{{ __('YouTube URL') }}</label>
        <input type="text" name="youtube_url" value="{{ Arr::get($attributes, 'youtube_url') }}" class="form-control" placeholder="{{ __('YouTube URL') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button icon image') }}</label>
        {!! Form::mediaImage('button_icon', Arr::get($attributes, 'button_icon')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background image') }}</label>
        {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
    </div>
</section>
