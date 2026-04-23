@php
    $alerts = [
        'success' => 'success',
        'info' => 'info',
        'delete' => 'danger',
    ];
@endphp

@foreach ($alerts as $alert => $class)
    @if (session()->has($alert))
        <div class="alert alert-{{ $class }}">
            {{ session($alert) }}
        </div>
    @endif
@endforeach


