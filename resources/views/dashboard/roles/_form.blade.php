
<div class="form-group">
    <x-form.label id="name">Role Name</x-form.label>
    <x-form.input name="name" :value="$role -> name" />
</div>

<fieldset>
    <legend>Permissions</legend>

    @foreach($permissions as $permission)
        <div class="form-check">
            <input
                type="checkbox"
                class="form-check-input"
                name="permissions[]"
                value="{{ $permission->name }}"
                id="permission-{{ $permission->id }}"
                @checked(
                    $role->exists &&
                    $role->hasPermissionTo($permission)
                )
            >

            <label
                class="form-check-label"
                for="permission-{{ $permission->id }}"
            >
                {{ $permission->name }}
            </label>
        </div>
    @endforeach
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
