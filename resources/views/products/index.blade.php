{{-- @extends('include.bootstrap')

@section('content')

    <div class="container">
        <h1>Products</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create New Product</a>
        <form action="{{ route('products.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control mr-2" placeholder="Search products..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>
        <ul class="list-group">
            @foreach($products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $product->name }}</strong> ({{ $product->category->name }}) - ${{ $product->price }}<br>
                        {{ $product->description }}
                    </div>
                    <div>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection --}}






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Product List</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="productTable">
            @foreach($products as $product)
            <tr id="product{{$product->id}}">
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->category->name}}</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm" onclick="editProduct({{$product->id}})">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct({{$product->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    @csrf
                    <input type="hidden" id="edit_product_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Product Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Price</label>
                        <input type="text" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_category_id">Category</label>
                        <select class="form-control" id="edit_category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Add Product
    $('#addProductForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ route('products.store') }}",
            data: $('#addProductForm').serialize(),
            success: function(response){
                $('#addProductModal').modal('hide');
                $('#productTable').append('<tr id="product'+response.id+'"><td>'+response.name+'</td><td>'+response.description+'</td><td>'+response.price+'</td><td>'+response.category.name+'</td><td><a href="#" class="btn btn-info btn-sm" onclick="editProduct('+response.id+')">Edit</a><button class="btn btn-danger btn-sm" onclick="deleteProduct('+response.id+')">Delete</button></td></tr>');
                $('#name').val('');
                $('#description').val('');
                $('#price').val('');
            }
        });
    });

    // Edit Product
    function editProduct(id){
        $.get('/products/'+id+'/edit', function(product){
            $('#edit_product_id').val(product.id);
            $('#edit_name').val(product.name);
            $('#edit_description').val(product.description);
            $('#edit_price').val(product.price);
            $('#edit_category_id').val(product.category_id);
            $('#editProductModal').modal('show');
        });
    }

    // Update Product
    $('#editProductForm').submit(function(e){
        e.preventDefault();
        var id = $('#edit_product_id').val();
        $.ajax({
            type: "PUT",
            url: "/products/"+id,
            data: $('#editProductForm').serialize(),
            success: function(response){
                $('#editProductModal').modal('hide');
                $('#product'+response.id+' td:nth-child(1)').text(response.name);
                $('#product'+response.id+' td:nth-child(2)').text(response.description);
                $('#product'+response.id+' td:nth-child(3)').text(response.price);
                $('#product'+response.id+' td:nth-child(4)').text(response.category.name);
            }
        });
    });

    // Delete Product
    function deleteProduct(id){
        if(confirm("Are you sure you want to delete this product?")){
            $.ajax({
                type: "DELETE",
                url: "/products/"+id,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#product'+id).remove();
                }
            });
        }
    }
</script>

</body>
</html>
