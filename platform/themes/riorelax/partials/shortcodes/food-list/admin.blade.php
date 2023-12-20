<div class="form-group">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="number" min="1" name="limit" value="{{ Arr::get($attributes, 'limit') }}" class="form-control" placeholder="{{ __('Limit') }}">
</div>
