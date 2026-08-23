<div class="auth-form">
    <div class="text-center mb-4">
        <h2>{{ trans('Create Account') }}</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="_dialog" value="REGISTER">

        @php
            $registerErrors = old('_dialog') === 'REGISTER';
        @endphp

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">{{ trans('name') }}</label>

            <input
                id="name"
                class="form-control {{ $registerErrors && $errors->has('name') ? 'is-invalid' : '' }}"
                type="text"
                name="name"
                value="{{ $registerErrors ? old('name') : '' }}"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ trans('Enter your name') }}"
            >

            @if ($registerErrors)
                @error('name')
                    <div class="text-danger small mt-1" data-error-for="name" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            @endif
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">{{ trans('Email Address') }}</label>

            <input
                id="email"
                class="form-control {{ $registerErrors && $errors->has('email') ? 'is-invalid' : '' }}"
                type="email"
                name="email"
                value="{{ $registerErrors ? old('email') : '' }}"
                required
                autocomplete="username"
                placeholder="{{ trans('Enter your email') }}"
            >

            @if ($registerErrors)
                @error('email')
                    <div class="text-danger small mt-1" data-error-for="email" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">{{ trans('Password') }}</label>

            <input
                id="password"
                class="form-control {{ $registerErrors && $errors->has('password') ? 'is-invalid' : '' }}"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="{{ trans('Create a password') }}"
            >

            @if ($registerErrors)
                @error('password')
                    <div class="text-danger small mt-1" data-error-for="password" role="alert">
                        {{ $message }}
                    </div>
                @endif
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">{{ trans('Confirm Password') }}</label>
            <input
                id="password_confirmation"
                class="form-control"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="{{ trans('Confirm Password') }}"
            >
        </div>

        <button type="submit" class="btn w-100 auth-submit">{{ trans('Create Account') }}</button>

        <div class="text-center mt-3 auth-footer">
            <span>{{ trans('Already have an account?') }}</span>

            <a href="?dialog=LOGIN" class="auth-btn">{{ trans('Log In') }}</a>
        </div>
    </form>
</div>
