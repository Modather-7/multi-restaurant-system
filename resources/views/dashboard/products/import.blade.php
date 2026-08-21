@extends('adminlte::page')

@section('title', 'Import Products')

@section('content_header')
    <h1>Import Products</h1>
@stop

@section('content')

    <form
        action="{{ route('dashboard.products.import') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="form-group">
            <label for="file">Products File</label>

            <input
                type="file"
                name="file"
                id="file"
                class="form-control @error('file') is-invalid @enderror"
                accept=".xlsx,.xls,.csv"
                required
            >

            @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Import Products
        </button>
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
