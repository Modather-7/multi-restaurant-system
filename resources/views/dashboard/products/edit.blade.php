@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.products.update', $product -> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('dashboard.products._form', [
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
