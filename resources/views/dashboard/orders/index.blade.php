@extends('adminlte::page')

@section('title', 'Orders')

@section('content_header')
    <h1>Orders</h1>
@stop

@section('content')

    <div class="mt-4">
        <x-alert />
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            <tr>
                <td>{{ $order -> id }}</td>
                <td>{{ $order -> created_at }}</td>
                <td>
                <td>
                    <a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route ('dashboard.orders.destroy', $order->id) }}" method="POST">
                        @csrf
                        {{-- Form method spoofing --}}
                        <input type="hidden" name="_method" value="delete">
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No Orders Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
@stop

