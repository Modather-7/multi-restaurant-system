@extends('adminlte::page')

@section('title', 'Add New Admin')

@section('content_header')
    <h1>Add New Admin</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.admins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.admins._form', [
            'button_label' => 'Save'
        ])
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
