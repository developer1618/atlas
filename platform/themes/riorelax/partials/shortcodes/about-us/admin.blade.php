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
        <label class="control-label">{{ __('Highlights') }}</label>
        <textarea name="highlights" class="form-control" placeholder="{{ __('Highlights') }}">{{ Arr::get($attributes, 'highlights') }}</textarea>
        <p class="text-muted">{{ __('Split each highlight by semicolon ‘; ’ for a new bulleted row.') }}</p>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Style') }}</label>
        {!! Form::customSelect('style', [
            'style-1'  => __('Style :number', ['number' => 1]),
            'style-2'  => __('Style :number', ['number' => 2]),
        ], Arr::get($attributes, 'style')) !!}
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

    <div class="form-group">
        <label class="control-label">{{ __('Signature image') }}</label>
        {!! Form::mediaImage('signature_image', Arr::get($attributes, 'signature_image')) !!}
    </div>

    <div class="form-group">
        <label for="button_label">{{ __('Signature author') }}</label>
        <input type="text" name="signature_author" value="{{ Arr::get($attributes, 'signature_author') }}" class="form-control" placeholder="{{ __('Signature author') }}">
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Top left image') }}</label>
                {!! Form::mediaImage('top_left_image', Arr::get($attributes, 'top_left_image')) !!}
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Bottom right image') }}</label>
                {!! Form::mediaImage('bottom_right_image', Arr::get($attributes, 'bottom_right_image')) !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Floating right image') }}</label>
        {!! Form::mediaImage('floating_right_image', Arr::get($attributes, 'floating_right_image')) !!}
    </div>
</section>
