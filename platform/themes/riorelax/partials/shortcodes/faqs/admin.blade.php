<section>
    <div class="form-group">
        <label class="control-label">{{ __('FAQ categories') }}</label>
        <select class="select-full" name="category_ids" multiple>
            @foreach($categories as $key => $value)
                <option @selected(in_array($key, $categoryIds)) value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</section>
