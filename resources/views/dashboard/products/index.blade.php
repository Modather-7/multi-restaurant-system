@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Add Product</a>
        <a href="{{ route('dashboard.products.trash') }}" class="btn btn-sm btn-outline-dark">Go To Trash</a>
    </div>

    {{-- Search Form --}}
    <form action="{{ URL::current() }}" method="get" class="d-flex" justify-content-between mb-4>
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <x-form.select
            name="status"
            :options="[
                'All'     => 'All',
                'active'  => 'Active',
                'draft'   => 'Draft',
                'achived' => 'Archived',
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
                <th>Restaurant</th>
                <th>Category</th>
                <th>Ingredients</th>
                <th>Price</th>
                <th>Status</th>
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
                <td>{{ $product -> restaurant -> name ?? '-' }}</td>
                <td>{{ $product -> category -> name ?? '-' }}</td>
                <td>{{ $product -> ingredients }}</td>
                <td>{{ $product -> price }}</td>
                <td>{{ $product -> status }}</td>
                <td>{{ $product -> created_at }}</td>
                <td>
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            height="100"
                            style="border: 2px solid #ddd; padding: 3px; border-radius: 10%;"
                        >

                        <form
                            action="{{ route('dashboard.products.delete-image', $product->id) }}"
                            method="POST"
                            class="mt-2"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger"
                            >
                                Remove Image
                            </button>
                        </form>
                    @else
                        -
                    @endif
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
