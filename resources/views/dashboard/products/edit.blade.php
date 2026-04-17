@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
    <form action="{{ route('dashboard.products.update', $product -> id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product -> name }}">
        </div>
        <div class="form-group">
            <label for="">Category</label>
            <select name="category_id" class="form-control form-select">
                <option value="selected"></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($product -> category_id == $category -> id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Product Ingredients</label>
            <textarea name="ingredients" class="form-control">{{ $product -> ingredients }}</textarea>
        </div>
        <div class="form-group">
            <label for="">Price</label>
            <input type="number" name="price" class="form-control" value="{{ $product -> price }}">
        </div>
        <div class="form-group">
            <label for="">Quantity</label>
            <input type="number" name="quantity" class="form-control" value="{{ $product -> quantity }}">
        </div>
        <div class="form-group">
            <label for="">Is_Available</label>
            <select name="is_available" class="form-control">
                <option value="1" @selected($product -> is_available == 1)>True</option>
                <option value="0" @selected($product -> is_available == 0)>False</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
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
