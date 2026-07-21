@extends('adminlte::page')

@section('title', 'categories')

@section('content_header')
    <h1>Categories</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Add Category</a>
        <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-sm btn-outline-dark">Go To Trash</a>
    </div>

    {{-- Search Form --}}
    <form action="{{ URL::current() }}" method="get" class="d-flex" justify-content-between mb-4>
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
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
                <th>Created At</th>
                <th>Image</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category -> id }}</td>
                <td>{{ $category -> name }}</td>
                <td>{{ $category -> restaurant -> name ?? '-' }}</td>
                <td>{{ $category -> created_at }}</td>
                <td>
                    @if($category->image)
                        <img
                            src="{{ asset('storage/' . $category->image) }}"
                            alt="{{ $category->name }}"
                            height="100"
                            style="border: 2px solid #ddd; padding: 3px; border-radius: 10%;"
                        >

                        <form
                            action="{{ route('dashboard.categories.delete-image', $category->id) }}"
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
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route ('dashboard.categories.destroy', $category->id) }}" method="POST">
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
                <td colspan="3">No Categories Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
