@extends('adminlte::page')

@section('title', 'Edit Admin')

@section('content_header')
    <h1>Edit Admin</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.admins.update', $admin -> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('dashboard.admins._form', [
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
