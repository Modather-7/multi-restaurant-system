@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>Roles</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-sm btn-outline-primary mr-2">Add Role</a>
        {{-- <a href="{{ route('dashboard.roles.trash') }}" class="btn btn-sm btn-outline-dark">Go To Trash</a> --}}
    </div>

    <div class="mt-4">
        <x-alert />
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($roles as $role)
            <tr>
                <td>{{ $role -> id }}</td>
                <td>{{ $role -> name }}</td>
                <td>{{ $role -> created_at }}</td>
                <td>
                <td>
                    <a href="{{ route('dashboard.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route ('dashboard.roles.destroy', $role->id) }}" method="POST">
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
                <td colspan="3">No Roles Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>
@stop

