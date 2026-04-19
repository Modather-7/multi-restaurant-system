@extends('adminlte::page')

@section('title', 'products')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary">Add Product</a>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Ingredients</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Is Available</th>
                <th>Created At</th>
                <th>Image</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product -> id }}</td>
                <td>{{ $product -> name }}</td>
                <td>{{ $product -> category-> name ?? '-' }}</td>
                <td>{{ $product -> ingredients }}</td>
                <td>{{ $product -> price }}</td>
                <td>{{ $product -> quantity }}</td>
                <td>{{ $product -> is_available ? 'True' : 'False'}}</td>
                <td>{{ $product -> created_at }}</td>
                <td><img
                    src="{{ asset('storage/' . $product->image) }}"
                    alt=""
                    height="100"
                    style="border: 2px solid #ddd; padding: 3px; border-radius: 50%;"
                    >
                </td>
                <td>
                    <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route ('dashboard.products.destroy', $product->id) }}" method="POST">
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
                <td colspan="10">No Products Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
