@props([
    'type' => 'text', 'name', 'value' => ''
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
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
    ]) }}
    value="{{ old($name, $value) }}" {{-- Gets the old name in POST request only --}}
    >
