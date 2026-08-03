@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
    <h1>Edit Role</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.roles.update', $role -> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('dashboard.roles._form', [
            'button_label' => 'Update'
        ]) {{-- _ معناها ان دا ملف داخلي او فرعي مش رئيسي فيه الفورم اللي محتاجين نعملها include --}}
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
