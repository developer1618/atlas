<div class="container pt-120">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h1 class="panel-heading">{{ __('Forgot Password') }}
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form
                    class="form-horizontal"
                    role="form"
                    method="POST"
                    action="{{ route('customer.password.request') }}"
                >
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label
                            class="col-md-4 control-label"
                            for="email"
                        >{{ __('E-Mail Address') }}</label>
                        <div class="col-md-6">
                            <input
                                class="form-control"
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                            >
                            {!! Form::error('email', $errors) !!}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="col-md-6 col-md-offset-4">
                            <button
                                class="btn btn-primary"
                                type="submit"
                            >
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
