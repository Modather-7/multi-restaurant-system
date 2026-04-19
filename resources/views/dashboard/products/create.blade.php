@extends('adminlte::page')

@section('title', 'Add New Product')

@section('content_header')
    <h1>Add New Product</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('dashboard.products._form', [
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
