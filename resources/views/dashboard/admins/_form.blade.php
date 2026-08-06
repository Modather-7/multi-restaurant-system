@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.label id="name">Admin Name</x-form.label>
    <x-form.input name="name" :value="$admin -> name" />
</div>

<div class="form-group">
    <x-form.label id="email">Admin Email</x-form.label>
    <x-form.input name="email" :value="$admin -> email" />
</div>

<div class="form-group">
    <x-form.label id="username">Admin Username</x-form.label>
    <x-form.input name="username" :value="$admin -> username" />
</div>

<div class="form-group">
    <x-form.label id="password">Admin Password</x-form.label>
    <x-form.input type="password" name="password"/>
</div>

<div class="form-group">
    <x-form.label id="password_confirmation">Confirm Password</x-form.label>
    <x-form.input
        type="password"
        name="password_confirmation"
    />
</div>

<div class="form-group">
    <x-form.label id="phone_number">Admin Phone Number</x-form.label>
    <x-form.input name="phone_number" :value="$admin -> phone_number" />
</div>

<div class="form-group">
    <x-form.label id="restaurant">Restaurant</x-form.label>
    <x-form.select name="restaurant_id" :options="$restaurants->pluck('name','id')" :selected="$admin -> restaurant_id"
    placeholder="--Select Restautant--"/> {{-- This is experimental system not final edition --}}
</div>

<fieldset>
    <legend>Roles</legend>

        @foreach ($roles as $role)
            <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                name="roles[]"
                value="{{ $role->id }}"
                @checked(in_array($role->id, old('roles', $admin_roles ?? [])))
            >

                <label class="form-check-label">
                    {{ $role->name }}
                </label>
            </div>
        @endforeach

</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
