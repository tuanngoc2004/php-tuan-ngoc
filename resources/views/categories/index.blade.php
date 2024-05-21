<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Category List</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            @foreach($categories as $category)
            <tr id="category{{$category->id}}">
                <td>{{$category->name}}</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm" onclick="editCategory({{$category->id}})">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteCategory({{$category->id}})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    <input type="hidden" id="edit_category_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Category Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="submit" id="btn_cancle" class="btn btn-info">Cancle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Add Category
    $('#addCategoryForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ route('categories.store') }}",
            data: $('#addCategoryForm').serialize(),
            success: function(response){
                $('#addCategoryModal').modal('hide');
                $('#categoryTable').append('<tr id="category'+response.id+'"><td>'+response.name+'</td><td><a href="#" class="btn btn-info btn-sm" onclick="editCategory('+response.id+')">Edit</a><button class="btn btn-danger btn-sm" onclick="deleteCategory('+response.id+')">Delete</button></td></tr>');
            }
        });
    });

    // Edit Category
    function editCategory(id){
        $.get('/categories/'+id+'/edit', function(category){
            $('#edit_category_id').val(category.id);
            $('#edit_name').val(category.name);
            $('#btn_cancle').val('');
            $('#editCategoryModal').modal('show');
        });
    }

    // Update Category
    $('#editCategoryForm').submit(function(e){
        e.preventDefault();
        var id = $('#edit_category_id').val();
        $.ajax({
            type: "PUT",
            url: "/categories/"+id,
            data: $('#editCategoryForm').serialize(),
            success: function(response){
                $('#editCategoryModal').modal('hide');
                $('#category'+response.id+' td:first-child').text(response.name);
            }
        });
    });

    // Delete Category
    function deleteCategory(id){
        if(confirm("Are you sure you want to delete this category?")){
            $.ajax({
                type: "DELETE",
                url: "/categories/"+id,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    $('#category'+id).remove();
                }
            });
        }
    }
</script>

</body>
</html>



{{-- @extends('include.bootstrap')

@section('content')
    <div class="container">
        <h1>Categories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $category->name }}
                    <div>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
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
