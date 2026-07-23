<div class="auth-form">

    <div class="text-center mb-5">
        <h2>
            Login
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
                Email Address
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
                placeholder="Enter your email"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="form-label">
                Password
            </label>

            <input
                id="password"
                class="form-control"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
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
                    Remember me
                </span>

            </label>

            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif

        </div>

        <button
            type="submit"
            class="btn w-100 auth-submit"
        >
            Login
        </button>

        <div class="text-center mt-4 auth-footer">
            <span>
                Don't have an account?
            </span>

            <a href="{{ request()->fullUrlWithQuery(['dialog'=>'REGISTER']) }}">
                Create account
            </a>

        </div>
    </form>

</div>
