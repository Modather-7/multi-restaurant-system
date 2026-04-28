@props([
    'type' => 'text', 'name', 'value' => ''
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name),
    ]) }}
    value="{{ old($name, $value) }}" {{-- Gets the old name in POST request only --}}
    >
