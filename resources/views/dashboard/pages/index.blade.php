@extends('adminlte::page')

@section('title', 'Admin Pages')

@section('content_header')
    <h1>Admin Pages</h1>
@stop

@section('content')
    <table class="table">
        <theads>
            <tr>
                <th>Name</th>
            </tr>
        </theads>
        <tbody>
            <tr>
                <td><a href="{{ route('dashboard.products.index') }}">Product Page</a></td>
            </tr>
        </tbody>
    </table>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
