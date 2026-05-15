@props([
    'name', 'options' => [], 'selected' => null, 'placeholder' => ''
])

<select
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name),
        'border-gray-300',
        'dark:border-gray-700',
        'dark:bg-gray-900',
        'dark:text-gray-300',
        'focus:border-indigo-500',
        'dark:focus:border-indigo-600',
        'focus:ring-indigo-500',
        'dark:focus:ring-indigo-600',
        'rounded-md shadow-sm',
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
