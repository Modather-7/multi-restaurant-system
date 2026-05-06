@extends('adminlte::page')

@section('title', 'Trashed Products')

@section('content_header')
    <h1>Trashed Products</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-sm btn-outline-primary">Back To Products</a>
    </div>

    {{-- Search Form --}}
    <form action="{{ URL::current() }}" method="get" class=d-flex justify-content-between mb-4>
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <x-form.select
            name="status"
            :options="[
                'active'  => 'Active',
                'draft'   => 'Draft',
                'archived' => 'Archived',
            ]"
            :selected="request('status')"
            class="mx-2" />
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <div class="mt-4">
        <x-alert />
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Ingredients</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th>Image</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product -> id }}</td>
                <td>{{ $product -> name }}</td>
                <td>{{ $product -> ingredients }}</td>
                <td>{{ $product -> price }}</td>
                <td>{{ $product -> quantity }}</td>
                <td>{{ $product -> status }}</td>
                <td>{{ $product -> deleted_at }}</td>
                <td><img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt=""
                    height="100"
                    style="border: 2px solid #ddd; padding: 3px; border-radius: 10%;"
                    >
                </td>
                <td>
                    <form action="{{ route ('dashboard.products.restore', $product-> id) }}" method="POST">
                        @csrf
                        {{-- Form method spoofing --}}
                        <input type="hidden" name="_method" value="delete">
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route ('dashboard.products.force-delete', $product-> id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10">No Products Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $products->withQueryString()->appends(['search' => 1])->links() }}
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
