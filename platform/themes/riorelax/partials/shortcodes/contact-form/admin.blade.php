<section>
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button Label') }}</label>
        <input type="text" name="title_button" value="{{ Arr::get($attributes, 'title_button') }}" class="form-control" placeholder="{{ __('Title Button') }}">
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Address icon') }}</label>
                {!! Form::themeIcon('address_icon', Arr::get($attributes, 'address_icon')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Address label') }}</label>
                <input type="text" name="address_label" value="{{ Arr::get($attributes, 'address_label') }}" class="form-control" placeholder="{{ __('Address label') }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ __('Address detail') }}</label>
                <textarea name="address_detail" class="form-control" placeholder="{{ __('Address detail') }}">{{ Arr::get($attributes, 'address_detail') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Email icon') }}</label>
                {!! Form::themeIcon('email_icon', Arr::get($attributes, 'email_icon')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Email label') }}</label>
                <input type="text" name="email_label" value="{{ Arr::get($attributes, 'email_label') }}" class="form-control" placeholder="{{ __('Email label') }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ __('Email detail') }}</label>
                <textarea name="email_detail" class="form-control" placeholder="{{ __('Email detail') }}">{{ Arr::get($attributes, 'email_detail') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Work Time icon') }}</label>
                {!! Form::themeIcon('work_time_icon', Arr::get($attributes, 'work_time_icon')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Work Time label') }}</label>
                <input type="text" name="work_time_label" value="{{ Arr::get($attributes, 'work_time_label') }}" class="form-control" placeholder="{{ __('Work Time label') }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ __('Work Time detail') }}</label>
                <textarea name="work_time_detail" class="form-control" placeholder="{{ __('Work Time detail') }}">{{ Arr::get($attributes, 'work_time_detail') }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Phone icon') }}</label>
                {!! Form::themeIcon('phone_icon', Arr::get($attributes, 'phone_icon')) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">{{ __('Phone label') }}</label>
                <input type="text" name="phone_label" value="{{ Arr::get($attributes, 'phone_label') }}" class="form-control" placeholder="{{ __('Phone label') }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">{{ __('Phone detail') }}</label>
                <textarea name="phone_detail" class="form-control" placeholder="{{ __('Phone detail') }}">{{ Arr::get($attributes, 'phone_detail') }}</textarea>
            </div>
        </div>
    </div>
</section>
