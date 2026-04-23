@props([
    'name', 'value'
])

<textarea
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }}
    required>{{ old($name, $value) }}</textarea>
