@extends('include.bootstrap')

@section('content')

    <div class="container">
        <h1>Edit Product</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" value="{{ $product->price }}" class="form-control">
            </div>
            <div class="mb-3">
            <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>    
@endsection
