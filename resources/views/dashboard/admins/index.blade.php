@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <h1>Admins</h1>
@stop

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.admins.create') }}" class="btn btn-sm btn-outline-primary mr-2">Add Admin</a>
        {{-- <a href="{{ route('dashboard.admins.trash') }}" class="btn btn-sm btn-outline-dark">Go To Trash</a> --}}
    </div>

    <div class="mt-4">
        <x-alert />
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Restaurant</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admins as $admin)
            <tr>
                <td>{{ $admin -> id }}</td>
                <td>{{ $admin -> name }}</td>
                <td>{{ $admin -> email }}</td>
                <td>{{ $admin -> username }}</td>
                <td>{{ $admin -> restaurant -> name }}</td>
                <td>
                    @foreach ($admin->roles as $role)
                        <span class="badge badge-primary">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </td>
                <td>{{ $admin -> created_at }}</td>
                <td>
                <td>
                    <a href="{{ route('dashboard.admins.edit', $admin->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{ route ('dashboard.admins.destroy', $admin->id) }}" method="POST">
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
                <td colspan="3">No Admins Found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $admins->links() }}
    </div>
@stop

