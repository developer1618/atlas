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
        <label class="control-label">{{ __('Background color') }}</label>
        {!! Form::customColor('background_color', Arr::get($attributes, 'background_color', '#f7f5f1'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Background image') }}</label>
        {!! Form::mediaImage('background_image', Arr::get($attributes, 'background_image')) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Choose amenities') }}</label>
        <select class="select-full" name="amenity_ids" multiple>
            @foreach($amenities as $key => $value)
                <option @selected(in_array($key, $amenityIds)) value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</section>
