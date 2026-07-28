<div class="auth-form">

    <div class="text-center mb-4">
        <h2>
            {{ trans('Create Account') }}
        </h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">
                {{ trans('name') }}
            </label>

            <input
                id="name"
                class="form-control"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="{{ trans('Enter your name') }}"
            >

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>


        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">
                {{ trans('Email Address') }}
            </label>

            <input
                id="email"
                class="form-control"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="{{ trans('Enter your email') }}"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>


        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">
                {{ trans('Password') }}
            </label>

            <input
                id="password"
                class="form-control"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="{{ trans('Create a password') }}"
            >

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>


        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label">
                {{ trans('Confirm Password') }}
            </label>

            <input
                id="password_confirmation"
                class="form-control"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="{{ trans('Confirm Password') }}"
            >

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>


        <button
            type="submit"
            class="btn w-100 auth-submit"
        >
            {{ trans('Create Account') }}
        </button>


        <div class="text-center mt-3 auth-footer">
            <span>
                {{ trans('Already have an account?') }}
            </span>

            <a href="{{ request()->fullUrlWithQuery(['dialog'=>'LOGIN']) }}">
                {{ trans('Log In') }}
            </a>
        </div>

    </form>

</div>
