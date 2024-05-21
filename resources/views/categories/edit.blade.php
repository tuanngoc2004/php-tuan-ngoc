@extends('include.bootstrap')

@section('content')
    <title>Edit Category</title>
</head>
<body>
    <div class="container">
        <form method="POST" action="{{ route('categories.update',  $category->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name"> Name:</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}">
            </div>
            <button type="submit" class="form-control btn btn-outline-info">Update Category</button>
        </form>
@endsection
