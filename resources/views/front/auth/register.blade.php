<div class="auth-form">

    <div class="text-center mb-4">
        <h2>
            Create Account
        </h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">
                Name
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
                placeholder="Enter your name"
            >

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>


        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">
                Email Address
            </label>

            <input
                id="email"
                class="form-control"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="Enter your email"
            >

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>


        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">
                Password
            </label>

            <input
                id="password"
                class="form-control"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Create a password"
            >

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>


        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label">
                Confirm Password
            </label>

            <input
                id="password_confirmation"
                class="form-control"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Confirm your password"
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
            Create Account
        </button>


        <div class="text-center mt-3 auth-footer">
            <span>
                Already have an account?
            </span>

            <a href="{{ request()->fullUrlWithQuery(['dialog'=>'LOGIN']) }}">
                Login
            </a>
        </div>

    </form>

</div>
