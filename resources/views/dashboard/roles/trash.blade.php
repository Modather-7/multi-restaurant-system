@extends('adminlte::page')

@section('title', 'Trashed Roles')

@section('content_header')
    <h1>Trashed Roles</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-sm btn-outline-primary">Back To Roles</a>
    </div>


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
            @forelse ($roles as $role)
            <tr>
                <td>{{ $role -> id }}</td>
                <td>{{ $role -> name }}</td>
                <td>{{ $role -> deleted_at }}</td>
                <td>
                    <form action="{{ route ('dashboard.roles.restore', $role->id) }}" method="POST">
                        @csrf
                        {{-- Form method spoofing --}}
                        <input type="hidden" name="_method" value="delete">
                        @method('put')
                        <button type="submit" class="btn btn-sm btn-outline-info">restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route ('dashboard.roles.force-delete', $role->id) }}" method="POST">
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
                <td colspan="10">No Roles Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $roles->withQueryString()->links() }}
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
