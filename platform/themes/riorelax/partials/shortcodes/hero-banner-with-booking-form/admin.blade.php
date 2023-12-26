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
        <label class="control-label">{{ __('Background image') }}</label>
        {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background color') }}</label>
        {!! Form::customColor('background_color', Arr::get($attributes, 'background_color', '#101010'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button label') }}</label>
        <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" placeholder="{{ __('Button label') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button URL') }}</label>
        <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" placeholder="{{ __('Button URL') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Form title') }}</label>
        <input type="text" name="form_title" value="{{ Arr::get($attributes, 'form_title') }}" class="form-control" placeholder="{{ __('Form title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Form Button label') }}</label>
        <input type="text" name="form_button_label" value="{{ Arr::get($attributes, 'form_button_label') }}" class="form-control" placeholder="{{ __('Form Button label') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Form Button URL') }}</label>
        <input type="text" name="form_button_url" value="{{ Arr::get($attributes, 'form_button_url') }}" class="form-control" placeholder="{{ __('Button URL') }}">
    </div>
</section>
