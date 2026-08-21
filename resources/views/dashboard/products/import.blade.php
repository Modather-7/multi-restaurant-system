@extends('adminlte::page')

@section('title', 'Add New Product')

@section('content_header')
    <h1>Import Products</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <x-form.input label="Products Count" class="form-control-lg" name="count" />
        </div>
        <button type="submit" class="btn btn-primary">Start Import...</button>
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
