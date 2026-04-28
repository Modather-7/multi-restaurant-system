@props([
    'name', 'options' => [], 'selected' => null, 'placeholder' => ''
])

<select
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name),
    ])}}
    required
    >

    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach ($options as $value => $text)
        <option
            value="{{ $value }}"
            @selected(old($name, $selected) == $value)>
            {{ $text }}
        </option>
    @endforeach
</select>
