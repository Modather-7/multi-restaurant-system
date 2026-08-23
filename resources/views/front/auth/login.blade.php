<div class="auth-form">

    <div class="text-center mb-5">
        <h2>
            {{ trans('Log In') }}
        </h2>
    </div>

    <x-auth-session-status
        class="mb-4"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <input type="hidden" name="_dialog" value="LOGIN">

        @php
            $loginErrors = old('_dialog') === 'LOGIN';
        @endphp

        <!-- Email -->
        <div class="mb-4">
            <label for="login-email" class="form-label">
                {{ trans('Email') }}
            </label>

            <input
                id="login-email"
                class="form-control {{ $loginErrors && $errors->has('email') ? 'is-invalid' : '' }}"
                type="email"
                name="email"
                value="{{ $loginErrors ? old('email') : '' }}"
                required
                autocomplete="username"
                placeholder="{{ trans('Enter your email') }}"
            >

            @if ($loginErrors)
                @error('email')
                    <div class="text-danger small mt-1" data-error-for="email" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            @endif
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="login-password" class="form-label">
                {{ trans('Password') }}
            </label>

            <input
                id="login-password"
                class="form-control {{ $loginErrors && $errors->has('password') ? 'is-invalid' : '' }}"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="{{ trans('Enter your password') }}"
            >

            @if ($loginErrors)
                @error('password')
                    <div class="text-danger small mt-1" data-error-for="password" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            @endif
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <label class="form-check d-flex align-items-center gap-2 mb-0" for="login-remember">
                <input
                    id="login-remember"
                    type="checkbox"
                    class="form-check-input mt-0"
                    name="remember"
                    value="1"
                    {{ old('remember') ? 'checked' : '' }}
                >

                <span>
                    {{ trans('Remember Me') }}
                </span>
            </label>

            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ trans('Forgot Your Password?') }}
                </a>
            @endif
        </div>

        <button
            type="submit"
            class="btn w-100 auth-submit"
        >
            {{ trans('Log In') }}
        </button>

        <div class="text-center mt-4 auth-footer">
            <span>
                {{ trans("Don't have an account?") }}
            </span>

            <a href="?dialog=REGISTER" class="auth-btn">
                {{ trans('Create Account') }}
            </a>
        </div>
    </form>
</div>
