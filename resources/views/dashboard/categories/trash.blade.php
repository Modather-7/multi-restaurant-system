@extends('adminlte::page')

@section('title', 'Trashed Categories')

@section('content_header')
    <h1>Trashed Categories</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-sm btn-outline-primary">Back To Categories</a>
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
                <th>Deleted At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category -> id }}</td>
                <td>{{ $category -> name }}</td>
                <td>{{ $category -> deleted_at }}</td>
                <td>
                    <form action="{{ route ('dashboard.categories.restore', $category->id) }}" method="POST">
                        @csrf
                        {{-- Form method spoofing --}}
                        <input type="hidden" name="_method" value="delete">
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route ('dashboard.categories.force-delete', $category->id) }}" method="POST">
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
                <td colspan="10">No Categories Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $categories->withQueryString()->links() }}
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
