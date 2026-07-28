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

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email -->
        <div class="mb-4">

            <label class="form-label">
                {{ trans('Email') }}
            </label>

            <input
                id="email"
                class="form-control"
                type="text"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="{{ trans('Enter your email') }}"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="form-label">
                {{ trans('Password') }}
            </label>

            <input
                id="password"
                class="form-control"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="{{ trans('Enter your password') }}"
            >

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <label class="form-check d-flex align-items-center gap-2 mb-0">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="form-check-input mt-0"
                    name="remember"
                    value="1"
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

            <a href="{{ request()->fullUrlWithQuery(['dialog'=>'REGISTER']) }}">
                {{ trans('Create Account') }}
            </a>

        </div>
    </form>

</div>
